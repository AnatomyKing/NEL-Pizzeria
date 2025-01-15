<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;        // or whichever models
use App\Models\Klant;        // you'll need to adapt
use App\Models\Bestelling;
use App\Models\Bestelregel;

class BestelController extends Controller
{
    /**
     * Store a new order (called from the form on the home page).
     */
    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'naam'       => 'required|string|max:255',
            'adres'      => 'required|string|max:255',
            'woonplaats' => 'required|string|max:255',
            'telefoon'   => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'pizzas'     => 'required|array',
        ]);

        // 2. Create or find a "Klant"
        $klant = Klant::create([
            'naam'           => $request->naam,
            'adres'          => $request->adres,
            'woonplaats'     => $request->woonplaats,
            'telefoonnummer' => $request->telefoon,
            'emailadres'     => $request->email,
        ]);

        // 3. Create a "Bestelling"
        $bestelling = Bestelling::create([
            'datum'    => now(),
            'status'   => 'initieel',
            'klant_id' => $klant->id,
        ]);

        // 4. Create "Bestelregels" for each pizza ID + quantity
        foreach ($request->pizzas as $pizzaId => $aantal) {
            if ((int) $aantal === 0) {
                continue;
            }
            Bestelregel::create([
                'aantal'             => $aantal,
                'afmeting'           => 'normaal',
                'pizza_id'           => $pizzaId,
                'bestelling_id'      => $bestelling->id,
                'bestelling_pizza_id'=> $pizzaId, // adapt if your DB differs
            ]);
        }

        // 5. Redirect with success
        return redirect()->route('home')
                         ->with('success', 'Bedankt voor je bestelling!');
    }
}
