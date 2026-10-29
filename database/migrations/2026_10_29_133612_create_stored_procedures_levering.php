<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Maakt de stored procedures voor user story 2 (Toevoegen producten).
     */
    public function up(): void
    {
        // Eerst oude versies weghalen, zodat de migration opnieuw kan draaien
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetProductVanLeverancier');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_NieuweLevering');

        // Haalt de gegevens op voor het formulier "Levering product".
        // Geeft geen rij terug als deze leverancier dit product niet levert.
        DB::unprepared("
            CREATE PROCEDURE sp_GetProductVanLeverancier(
                 IN p_LeverancierId INT UNSIGNED
                ,IN p_ProductId INT UNSIGNED
            )
            BEGIN
                SELECT  L.Id AS LeverancierId
                       ,L.Naam AS LeverancierNaam
                       ,P.Id AS ProductId
                       ,P.Naam AS ProductNaam
                       ,P.IsActief AS ProductIsActief
                       ,M.AantalAanwezig
                FROM Leverancier AS L
                INNER JOIN ProductPerLeverancier AS PPL ON PPL.LeverancierId = L.Id
                INNER JOIN Product AS P ON P.Id = PPL.ProductId
                LEFT JOIN Magazijn AS M ON M.ProductId = P.Id
                WHERE L.Id = p_LeverancierId
                  AND P.Id = p_ProductId
                GROUP BY L.Id, L.Naam, P.Id, P.Naam, P.IsActief, M.AantalAanwezig;
            END
        ");

        // Voegt een nieuwe levering toe en verhoogt de voorraad in het magazijn.
        // Is het product niet meer actief, dan wordt er niets opgeslagen.
        // Resultaat: Gelukt = 1 (opgeslagen) of Gelukt = 0 (product niet meer actief).
        DB::unprepared("
            CREATE PROCEDURE sp_NieuweLevering(
                 IN p_LeverancierId INT UNSIGNED
                ,IN p_ProductId INT UNSIGNED
                ,IN p_Aantal INT
                ,IN p_DatumEerstVolgendeLevering DATE
            )
            BEGIN
                DECLARE v_IsActief INT DEFAULT 0;

                -- Gaat er iets mis? Dan alles ongedaan maken en de fout doorgeven
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                -- Is dit product nog actief?
                SELECT IsActief + 0 INTO v_IsActief
                FROM Product
                WHERE Id = p_ProductId;

                IF v_IsActief = 0 THEN
                    -- Product wordt niet meer gemaakt: niets opslaan
                    SELECT 0 AS Gelukt;
                ELSE
                    START TRANSACTION;

                    -- 1. De levering opslaan (DatumLevering is vandaag)
                    INSERT INTO ProductPerLeverancier
                        (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering)
                    VALUES
                        (p_LeverancierId, p_ProductId, CURDATE(), p_Aantal, p_DatumEerstVolgendeLevering);

                    -- 2. De voorraad in het magazijn ophogen (IFNULL: leeg telt als 0)
                    UPDATE Magazijn
                    SET AantalAanwezig = IFNULL(AantalAanwezig, 0) + p_Aantal
                    WHERE ProductId = p_ProductId;

                    COMMIT;

                    SELECT 1 AS Gelukt;
                END IF;
            END
        ");
    }

    /**
     * Haalt de stored procedures weer weg.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetProductVanLeverancier');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_NieuweLevering');
    }
};