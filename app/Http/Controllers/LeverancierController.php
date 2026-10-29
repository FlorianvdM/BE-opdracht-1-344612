<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;

class LeverancierController extends Controller
{
    // Wireframe 01: overzicht van alle leveranciers
    public function index()
    {
        // Het model haalt de gegevens op via de stored procedure
        $leveranciers = Leverancier::overzicht();

        return view('leverancier.index', [
            'leveranciers' => $leveranciers,
        ]);
    }

    // Wireframe 02 en 03: geleverde producten van één leverancier
    public function producten(int $id)
    {
        $leverancier = Leverancier::vindOpId($id);

        // Bestaat de leverancier niet? Dan een 404-pagina tonen
        abort_if($leverancier === null, 404);

        $producten = Leverancier::geleverdeProducten($id);

        return view('leverancier.producten', [
            'leverancier' => $leverancier,
            'producten'   => $producten,
        ]);
    }
}