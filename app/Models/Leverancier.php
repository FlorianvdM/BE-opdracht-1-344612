<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDO;

/**
 * Model voor leveranciers.
 * Alle data wordt opgehaald met PDO en stored procedures.
 */
class Leverancier
{
    // Geeft de PDO-verbinding terug die Laravel al heeft opgebouwd
    private static function pdo(): PDO
    {
        return DB::connection()->getPdo();
    }

    // Roept sp_OverzichtLeveranciers aan: alle leveranciers met aantal verschillende producten
    public static function overzicht(): array
    {
        $statement = self::pdo()->prepare('CALL sp_OverzichtLeveranciers()');
        $statement->execute();
        $rijen = $statement->fetchAll(PDO::FETCH_OBJ);
        $statement->closeCursor(); // nodig na een stored procedure

        return $rijen;
    }

    // Roept sp_GetLeverancier aan: één leverancier op Id (of null als hij niet bestaat)
    public static function vindOpId(int $id): ?object
    {
        $statement = self::pdo()->prepare('CALL sp_GetLeverancier(:id)');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $rij = $statement->fetch(PDO::FETCH_OBJ);
        $statement->closeCursor();

        return $rij === false ? null : $rij;
    }

    // Roept sp_GeleverdeProducten aan: de producten van één leverancier
    public static function geleverdeProducten(int $id): array
    {
        $statement = self::pdo()->prepare('CALL sp_GeleverdeProducten(:id)');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $rijen = $statement->fetchAll(PDO::FETCH_OBJ);
        $statement->closeCursor();

        return $rijen;
    }
}