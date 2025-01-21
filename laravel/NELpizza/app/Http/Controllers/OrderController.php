<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Store a new order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('Je moet ingelogd zijn om een bestelling te plaatsen.');
        }

        $user = Auth::user();

        // Validate incoming request data
        $validatedData = $request->validate([
            'adres' => 'required|string|max:255',
            'woonplaats' => 'required|string|max:255',
            'telefoonnummer' => 'required|string|max:15',
        ]);

        // Retrieve or create the klant record
        $klant = Klant::firstOrCreate(
            ['emailadres' => $user->email], // Search by email
            [
                'naam' => $user->name,
                'adres' => $validatedData['adres'],
                'woonplaats' => $validatedData['woonplaats'],
                'telefoonnummer' => $validatedData['telefoonnummer'],
            ]
        );

        // Create a new order associated with the klant
        $order = $klant->orders()->create([
            'bestelling_datum' => now(),
            'status' => 'in behandeling',
        ]);

        return redirect()->route('dashboard')->with('success', 'Uw bestelling is succesvol geplaatst!');
    }
}
