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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart'           => 'required|array|min:1',
            'naam'           => 'required|string|max:255',
            'adres'          => 'required|string|max:255',
            'woonplaats'     => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:255',
            'emailadres'     => 'required|email|max:255',
        ]);
    
        $cartItems = $validated['cart'];
    
        if (Auth::check()) {
            $user = Auth::user();
            $klant = $user->klants()->first() ?? new Klant();
        } else {
            $klant = new Klant();
        }
    
        $klant->fill($request->only(['naam', 'adres', 'woonplaats', 'telefoonnummer', 'emailadres']))->save();
    
        if (Auth::check() && !$user->klants->contains($klant->id)) {
            $user->klants()->attach($klant->id);
        }
    
        $bestelling = Bestelling::create([
            'datum'    => now(),
            'status'   => 'initieel',
            'klant_id' => $klant->id,
        ]);
    
        foreach ($cartItems as $item) {
            $afmeting = match ($item['sizeMultiplier'] ?? 1) {
                0.8 => 'klein',
                1.2 => 'groot',
                default => 'normaal',
            };
    
            $bestelregel = $bestelling->bestelregels()->create([
                'pizza_id' => $item['pizza_id'],
                'aantal'   => $item['quantity'],
                'afmeting' => $afmeting,
            ]);
    
            foreach ($item['chosenIngredients'] as $ingredient) {
                $quantity = min(max($ingredient['quantity'], 0), 5); // Ensure quantity is between 0 and 5
                if ($quantity > 0) {
                    $bestelregel->ingredients()->attach($ingredient['id'], [
                        'quantity' => $quantity
                    ]);
                }
            }
        }
    
        return response()->json([
            'message'  => 'Order placed successfully!',
            'order_id' => $bestelling->id,
        ]);
    }

}
