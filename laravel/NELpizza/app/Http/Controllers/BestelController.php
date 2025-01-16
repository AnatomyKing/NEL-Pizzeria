<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Bestelling;
use App\Models\Klant;
use App\Models\Pizza;

class BestelController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'cart' => 'required|array',
        ]);

        $cartItems = $validatedData['cart'];

        // Make sure we have a fake klant (ID=999) in DB
        // Or adjust to Klant::first()->id if you prefer
        $fakeKlantId = 999;

        // Ensure there's a valid fallback Pizza ID
        $fallbackPizzaId = Pizza::first()->id ?? 1;

        $bestelling = Bestelling::create([
            'datum'    => Carbon::now(),
            'status'   => 'initieel',
            'klant_id' => $fakeKlantId,  
            // If your 'bestellings' table must have a single pizza_id, pick any from the cart or fallback
            'pizza_id' => (count($cartItems) > 0)
                ? ($cartItems[0]['pizza_id'] ?? $fallbackPizzaId)
                : $fallbackPizzaId,
        ]);

        foreach ($cartItems as $item) {
            // Convert numeric multiplier to enum text
            $afmeting = match ($item['sizeMultiplier']) {
                0.8 => 'klein',
                1   => 'normaal',
                1.2 => 'groot',
                default => 'normaal'
            };

            // Insert into bestelregels
            $bestelling->bestelregels()->create([
                'aantal'   => $item['quantity'],
                'afmeting' => $afmeting,
                'pizza_id' => $item['pizza_id'], 
            ]);
        }

        return response()->json([
            'message' => 'Order placed successfully!',
            'order_id' => $bestelling->id
        ]);
    }
}
