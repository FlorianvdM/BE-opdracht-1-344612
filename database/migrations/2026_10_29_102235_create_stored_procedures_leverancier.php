<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Maakt de stored procedures voor user story 1 (Overzicht leveranciers).
     */
    public function up(): void
    {
        // Eerst oude versies weghalen, zodat de migration opnieuw kan draaien
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_OverzichtLeveranciers');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetLeverancier');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GeleverdeProducten');

        // Wireframe 01: alle leveranciers met het aantal verschillende producten.
        // COUNT(DISTINCT ...) telt elk product maar één keer, ook bij meerdere leveringen.
        // Gesorteerd op aantal producten aflopend (bij gelijk aantal op naam).
        DB::unprepared("
            CREATE PROCEDURE sp_OverzichtLeveranciers()
            BEGIN
                SELECT  L.Id
                       ,L.Naam
                       ,L.ContactPersoon
                       ,L.LeverancierNummer
                       ,L.Mobiel
                       ,COUNT(DISTINCT PPL.ProductId) AS AantalVerschillendeProducten
                FROM Leverancier AS L
                LEFT JOIN ProductPerLeverancier AS PPL
                       ON PPL.LeverancierId = L.Id
                WHERE L.IsActief = 1
                GROUP BY L.Id, L.Naam, L.ContactPersoon, L.LeverancierNummer, L.Mobiel
                ORDER BY AantalVerschillendeProducten DESC, L.Naam ASC;
            END
        ");

        // Haalt één leverancier op, voor de gegevens op het detailscherm
        DB::unprepared("
            CREATE PROCEDURE sp_GetLeverancier(IN p_LeverancierId INT UNSIGNED)
            BEGIN
                SELECT  L.Id
                       ,L.Naam
                       ,L.ContactPersoon
                       ,L.LeverancierNummer
                       ,L.Mobiel
                FROM Leverancier AS L
                WHERE L.Id = p_LeverancierId;
            END
        ");

        // Wireframe 02: de verschillende producten van één leverancier.
        // MAX(DatumLevering) geeft de laatste zending van dat product.
        // Gesorteerd op aantal in het magazijn aflopend.
        DB::unprepared("
            CREATE PROCEDURE sp_GeleverdeProducten(IN p_LeverancierId INT UNSIGNED)
            BEGIN
                SELECT  P.Id AS ProductId
                       ,P.Naam AS ProductNaam
                       ,P.IsActief AS ProductIsActief
                       ,M.VerpakkingsEenheid
                       ,M.AantalAanwezig
                       ,MAX(PPL.DatumLevering) AS DatumLaatsteLevering
                FROM ProductPerLeverancier AS PPL
                INNER JOIN Product AS P ON P.Id = PPL.ProductId
                LEFT JOIN Magazijn AS M ON M.ProductId = P.Id
                WHERE PPL.LeverancierId = p_LeverancierId
                GROUP BY P.Id, P.Naam, P.IsActief, M.VerpakkingsEenheid, M.AantalAanwezig
                ORDER BY M.AantalAanwezig DESC;
            END
        ");
    }

    /**
     * Haalt de stored procedures weer weg.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_OverzichtLeveranciers');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetLeverancier');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GeleverdeProducten');
    }
};