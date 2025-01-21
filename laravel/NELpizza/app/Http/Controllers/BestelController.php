<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Bestelling;
use App\Models\Bestelregel;
use App\Models\Klant;
use App\Models\Pizza;

class BestelController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'cart' => 'required|array',
            'cart.*.pizza_id' => 'required|integer|exists:pizzas,id',
            'cart.*.sizeMultiplier' => 'required|numeric|in:0.8,1,1.2',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        $cartItems = $validatedData['cart'];

        // Retrieve the logged-in user
        $user = Auth::user();

        // 1) Check if user already has an associated klant record
        //    (assuming your User model has 'klant_id', or you have a one-to-one relationship).
        $klant = $user->klant;  // E.g. $user->klant() relationship

        // 2) If no klant is found, create a new one and associate it with the user
        if (!$klant) {
            $klant = Klant::create([
                'naam'           => $user->name,
                'emailadres'     => $user->email,
                'adres'          => $request->input('adres', 'Unknown Address'),
                'woonplaats'     => $request->input('woonplaats', 'Unknown City'),
                'telefoonnummer' => $request->input('telefoonnummer', 'Unknown Phone'),
                // If your 'klant' table also has a 'user_id', fill it in here:
                // 'user_id'     => $user->id,
            ]);

            // If you have a user->klant_id column, link them
            // $user->klant_id = $klant->id;
            // $user->save();
        }

        // Ensure there's a valid fallback Pizza ID
        $fallbackPizzaId = Pizza::first()->id ?? 1;

        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Create a new bestelling using the existing/newly-created klant
            $bestelling = Bestelling::create([
                'datum'    => Carbon::now(),
                'status'   => 'initieel',
                'klant_id' => $klant->id,
                // Use the first cart item’s pizza_id if available, otherwise fallback
                'pizza_id' => (count($cartItems) > 0)
                    ? ($cartItems[0]['pizza_id'] ?? $fallbackPizzaId)
                    : $fallbackPizzaId,
            ]);

            // Loop through cart items and create bestelregels
            foreach ($cartItems as $item) {
                $afmeting = match ($item['sizeMultiplier']) {
                    0.8 => 'klein',
                    1   => 'normaal',
                    1.2 => 'groot',
                    default => 'normaal',
                };

                $bestelling->bestelregels()->create([
                    'aantal'    => $item['quantity'],
                    'afmeting'  => $afmeting,
                    'pizza_id'  => $item['pizza_id'],
                ]);
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'message'  => 'Order placed successfully!',
                'order_id' => $bestelling->id,
            ], 201);

        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to place order',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    
}
