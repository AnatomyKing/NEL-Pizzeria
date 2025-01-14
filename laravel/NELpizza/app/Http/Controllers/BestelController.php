<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Klant;
use App\Models\Bestelling;
use App\Models\Bestelregel;

class BestelController extends Controller
{
    /**
     * Display the pizza order form.
     */
    public function create()
    {
        // Fetch pizzas from the database (assuming you have a Pizza model/table).
        $pizzas = Pizza::all();

        // Return the bestel.blade.php view with the pizzas variable.
        return view('bestel', compact('pizzas'));
    }

    /**
     * Handle the form submission for placing an order.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming form data.
        $request->validate([
            'naam'       => 'required|string|max:255',
            'adres'      => 'required|string|max:255',
            'woonplaats' => 'required|string|max:255',
            'telefoon'   => 'required|string|max:255',
            'email'      => 'required|email|max:255',

            // 'pizzas' is an array where the key is the pizza ID and value is the quantity.
            'pizzas'     => 'required|array',
        ]);

        // 2. Create a new klant record (or find existing, up to you).
        $klant = Klant::create([
            'naam'           => $request->naam,
            'adres'          => $request->adres,
            'woonplaats'     => $request->woonplaats,
            'telefoonnummer' => $request->telefoon,
            'emailadres'     => $request->email,
        ]);

        // 3. Create the bestelling (order) record.
        $bestelling = Bestelling::create([
            'datum'    => now(),
            'status'   => 'initieel', // or any default status you want
            'klant_id' => $klant->id,
        ]);

        // 4. Loop over each pizza the user selected and create bestelregels (order lines).
        //    $request->pizzas will be something like: [3 => '2', 5 => '1', ...]
        //    where '3' is a pizza ID and '2' is the quantity.
        foreach ($request->pizzas as $pizzaId => $aantal) {
            // If the user didn't select any quantity (0), skip it.
            if ((int) $aantal === 0) {
                continue;
            }

            Bestelregel::create([
                'aantal'         => $aantal,
                'afmeting'       => 'normaal', // or implement a size selection in your form
                'pizza_id'       => $pizzaId,
                'bestelling_id'  => $bestelling->id,
                'bestelling_pizza_id' => $pizzaId, // Adjust if needed per your schema
            ]);
        }

        // 5. Redirect back to the form with a success message.
        return redirect()->route('bestel.create')
                         ->with('success', 'Bedankt voor je bestelling!');
    }
}
