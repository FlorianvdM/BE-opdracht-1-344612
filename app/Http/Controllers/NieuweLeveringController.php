<?php

namespace App\Http\Controllers;

use App\Models\Levering;
use Illuminate\Http\Request;

class NieuweLeveringController extends Controller
{
    // Wireframe 04: het formulier "Levering product" tonen
    public function create(int $leverancierId, int $productId)
    {
        $info = Levering::vindProductVanLeverancier($leverancierId, $productId);

        // Levert deze leverancier dit product niet? Dan een 404-pagina
        abort_if($info === null, 404);

        return view('leverancier.levering', [
            'info'    => $info,
            'melding' => null,
        ]);
    }

    // De knop "Sla op": gegevens controleren en de levering opslaan
    public function store(Request $request, int $leverancierId, int $productId)
    {
        $info = Levering::vindProductVanLeverancier($leverancierId, $productId);
        abort_if($info === null, 404);

        // Controleer wat de gebruiker heeft ingevuld
        $gegevens = $request->validate([
            'aantal'                       => ['required', 'integer', 'min:1'],
            'datum_eerstvolgende_levering' => ['required', 'date'],
        ], [
            'aantal.required'                       => 'Vul het aantal producteenheden in.',
            'aantal.integer'                        => 'Het aantal moet een heel getal zijn.',
            'aantal.min'                            => 'Het aantal moet minimaal 1 zijn.',
            'datum_eerstvolgende_levering.required' => 'Vul de datum van de eerstvolgende levering in.',
            'datum_eerstvolgende_levering.date'     => 'Vul een geldige datum in.',
        ]);

        // De stored procedure slaat de levering op en verhoogt de voorraad
        $gelukt = Levering::toevoegen(
            $leverancierId,
            $productId,
            (int) $gegevens['aantal'],
            $gegevens['datum_eerstvolgende_levering']
        );

        // Scenario 02: het product wordt niet meer geproduceerd
        if (!$gelukt) {
            return view('leverancier.levering', [
                'info'    => $info,
                'melding' => 'Het product ' . $info->ProductNaam . ' van de leverancier '
                           . $info->LeverancierNaam . ' wordt niet meer geproduceerd',
            ]);
        }

        // Scenario 01: terug naar Geleverde producten, met een bevestiging
        return redirect()
            ->route('leveranciers.producten', $leverancierId)
            ->with('status', 'De levering van ' . $info->ProductNaam . ' is toegevoegd aan het magazijn.');
    }
}