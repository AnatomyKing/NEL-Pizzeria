<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Klant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view. (Default from Laravel)
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request. (Modified to create Klant)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Add any Klant fields you want to collect at registration:
            'naam'           => ['required', 'string', 'max:255'],
            'adres'          => ['required', 'string', 'max:255'],
            'woonplaats'     => ['required', 'string', 'max:255'],
            'telefoonnummer' => ['required', 'string', 'max:255'],
            'emailadres'     => ['required', 'string', 'email', 'max:255'],
        ]);

        // Create the User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create the Klant
        $klant = Klant::create([
            'naam'           => $request->naam,
            'adres'          => $request->adres,
            'woonplaats'     => $request->woonplaats,
            'telefoonnummer' => $request->telefoonnummer,
            'emailadres'     => $request->emailadres,
        ]);

        // Attach pivot
        $user->klants()->attach($klant->id);

        event(new Registered($user));

        Auth::login($user);


        return redirect(route('dashboard', absolute: false));
    }
}
