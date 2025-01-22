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
     * Handle POST /bestel to create an order (Bestelling + Bestelregels).
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

        // Check if user is logged in -> reuse or create a Klant
        if (Auth::check()) {
            $user  = Auth::user();
            $klant = $user->klants()->first() ?? new Klant();
        } else {
            // Guest user -> brand new Klant
            $klant = new Klant();
        }

        // Fill the Klant record
        $klant->naam           = $request->naam;
        $klant->adres          = $request->adres;
        $klant->woonplaats     = $request->woonplaats;
        $klant->telefoonnummer = $request->telefoonnummer;
        $klant->emailadres     = $request->emailadres;
        $klant->save();

        // If logged in, attach user->klant pivot if not already attached
        if (Auth::check()) {
            if (!$user->klants->contains($klant->id)) {
                $user->klants()->attach($klant->id);
            }
        }

        // Create the main Bestelling
        $firstItemPizzaId = $cartItems[0]['pizza_id'] ?? null;
        $fallbackPizza    = Pizza::first();
        $fallbackPizzaId  = $fallbackPizza ? $fallbackPizza->id : null;

        $bestelling = Bestelling::create([
            'datum'    => Carbon::now(),     // or now()
            'status'   => 'initieel',
            'klant_id' => $klant->id,
            'pizza_id' => $firstItemPizzaId ?: $fallbackPizzaId,
        ]);

        // Create Bestelregels for each cart item
        foreach ($cartItems as $item) {
            // Convert numeric multiplier to text
            $afmeting = match ($item['sizeMultiplier'] ?? 1) {
                0.8 => 'klein',
                1.2 => 'groot',
                default => 'normaal',
            };

            $bestelling->bestelregels()->create([
                'pizza_id' => $item['pizza_id'],
                'aantal'   => $item['quantity'],
                'afmeting' => $afmeting,
                // Add more columns if needed, e.g. "ingredients" if you store them
            ]);
        }

        // Return success
        return response()->json([
            'message'  => 'Order placed successfully!',
            'order_id' => $bestelling->id,
        ]);
    }
}
