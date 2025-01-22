<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Klant;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    /**
     * Show the dashboard form to edit the user's Klant info.
     */
    public function edit()
    {
        $user = Auth::user();

        // Fetch the first Klant record attached to the user (assuming 1→1 usage).
        $klant = $user->klants()->first() ?: new Klant();

        return view('dashboard', compact('klant'));
    }

    /**
     * Update or create the Klant record for the authenticated user.
     */
    public function update(Request $request)
    {
        $request->validate([
            'naam'             => 'required|string|max:255',
            'adres'            => 'required|string|max:255',
            'woonplaats'       => 'required|string|max:255',
            'telefoonnummer'   => 'required|string|max:255',
            'emailadres'       => 'required|email|max:255',
        ]);

        $user = Auth::user();

        // If user has a klant, reuse it; else create a new one
        $klant = $user->klants()->first() ?: new Klant();

        // Fill Klant data
        $klant->naam           = $request->naam;
        $klant->adres          = $request->adres;
        $klant->woonplaats     = $request->woonplaats;
        $klant->telefoonnummer = $request->telefoonnummer;
        $klant->emailadres     = $request->emailadres;
        $klant->save();

        // Attach pivot if not already attached
        if (! $user->klants->contains($klant->id)) {
            $user->klants()->attach($klant->id);
        }

        return redirect()->route('dashboard')->with('status', 'Klant info updated!');
    }
}
