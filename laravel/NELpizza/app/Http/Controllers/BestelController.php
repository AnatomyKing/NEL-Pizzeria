<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Models\Bestelling;
use App\Models\Bestelregel;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BestelController extends Controller
{
    /**
     * Handle POST /bestel to create an order (Bestelling + Bestelregels),
     * supporting multiple pizzas in one order.
     */
    public function store(Request $request)
    {
        // Validate the cart & user info
        $validated = $request->validate([
            'cart'           => 'required|array|min:1',
            'naam'           => 'required|string|max:255',
            'adres'          => 'required|string|max:255',
            'woonplaats'     => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:255',
            'emailadres'     => 'required|email|max:255',
        ]);

        $cartItems = $validated['cart'];

        // 1) Determine the Klant
        if (Auth::check()) {
            // Reuse existing Klant or create a new one
            $user  = Auth::user();
            $klant = $user->klants()->first() ?? new Klant();
        } else {
            // Guest user => new Klant
            $klant = new Klant();
        }

        // Fill/update the Klant data
        $klant->naam           = $request->naam;
        $klant->adres          = $request->adres;
        $klant->woonplaats     = $request->woonplaats;
        $klant->telefoonnummer = $request->telefoonnummer;
        $klant->emailadres     = $request->emailadres;
        $klant->save();

        // If user is logged in, attach pivot if not already attached
        if (Auth::check()) {
            if (!$user->klants->contains($klant->id)) {
                $user->klants()->attach($klant->id);
            }
        }

        // 2) Create the Bestelling (no pizza_id)
        $bestelling = Bestelling::create([
            'datum'    => Carbon::now(),
            'status'   => 'initieel',
            'klant_id' => $klant->id,
        ]);

        // 3) Create one Bestelregel for each item in the cart
        foreach ($cartItems as $item) {
            // Convert numeric multiplier to text (afmeting)
            $afmeting = match ($item['sizeMultiplier'] ?? 1) {
                0.8 => 'klein',
                1.2 => 'groot',
                default => 'normaal',
            };

            $bestelling->bestelregels()->create([
                'pizza_id'    => $item['pizza_id'],        // references the pizzas table
                'aantal'      => $item['quantity'],
                'afmeting'    => $afmeting,
            ]);
        }

        // Return success JSON
        return response()->json([
            'message'  => 'Order placed successfully!',
            'order_id' => $bestelling->id,
        ]);
    }
}
