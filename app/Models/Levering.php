<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDO;

/**
 * Model voor het toevoegen van een nieuwe levering (user story 2).
 * Alle data gaat via PDO en stored procedures.
 */
class Levering
{
    // Geeft de PDO-verbinding terug die Laravel al heeft opgebouwd
    private static function pdo(): PDO
    {
        return DB::connection()->getPdo();
    }

    // Roept sp_GetProductVanLeverancier aan.
    // Geeft null terug als deze leverancier dit product niet levert.
    public static function vindProductVanLeverancier(int $leverancierId, int $productId): ?object
    {
        $statement = self::pdo()->prepare('CALL sp_GetProductVanLeverancier(:leverancierId, :productId)');
        $statement->bindValue(':leverancierId', $leverancierId, PDO::PARAM_INT);
        $statement->bindValue(':productId', $productId, PDO::PARAM_INT);
        $statement->execute();
        $rij = $statement->fetch(PDO::FETCH_OBJ);
        $statement->closeCursor(); // nodig na een stored procedure

        return $rij === false ? null : $rij;
    }

    // Roept sp_NieuweLevering aan.
    // true = levering opgeslagen, false = product wordt niet meer geproduceerd.
    public static function toevoegen(int $leverancierId, int $productId, int $aantal, string $datumEerstVolgendeLevering): bool
    {
        $statement = self::pdo()->prepare('CALL sp_NieuweLevering(:leverancierId, :productId, :aantal, :datum)');
        $statement->bindValue(':leverancierId', $leverancierId, PDO::PARAM_INT);
        $statement->bindValue(':productId', $productId, PDO::PARAM_INT);
        $statement->bindValue(':aantal', $aantal, PDO::PARAM_INT);
        $statement->bindValue(':datum', $datumEerstVolgendeLevering, PDO::PARAM_STR);
        $statement->execute();
        $rij = $statement->fetch(PDO::FETCH_OBJ);
        $statement->closeCursor();

        return $rij !== false && (int) $rij->Gelukt === 1;
    }
}