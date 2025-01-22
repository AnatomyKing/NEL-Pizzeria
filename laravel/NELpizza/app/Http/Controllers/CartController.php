<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the Cart page (GET /cart).
     * Auto-fill Klant data if the user is logged in.
     */
    public function index()
    {
        $klantData = [
            'naam'           => '',
            'adres'          => '',
            'woonplaats'     => '',
            'telefoonnummer' => '',
            'emailadres'     => '',
        ];

        if (Auth::check()) {
            $user  = Auth::user();
            $klant = $user->klants()->first();
            if ($klant) {
                $klantData = [
                    'naam'           => $klant->naam,
                    'adres'          => $klant->adres,
                    'woonplaats'     => $klant->woonplaats,
                    'telefoonnummer' => $klant->telefoonnummer,
                    'emailadres'     => $klant->emailadres,
                ];
            }
        }

        return view('cart', compact('klantData'));
    }
}
