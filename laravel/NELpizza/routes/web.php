<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\BestelController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use App\Models\OrderBestelling;
use Illuminate\Http\Request;
use App\Models\Klant;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/







Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');



Route::get('/test-auth', function () {
    $user = Auth::user(); // You can also use auth()->user()
    dd($user);
});



Route::post('/klant/save', function (Request $request) {
    // Validate the customer data
    $validated = $request->validate([
        'naam' => 'required|string|max:255',
        'adres' => 'required|string|max:255',
        'woonplaats' => 'required|string|max:255',
        'telefoonnummer' => 'required|string|max:15',
        'emailadres' => 'required|email|max:255',
    ]);

    // Check if the customer already exists based on email
    $klant = Klant::where('emailadres', $validated['emailadres'])->first();

    if ($klant) {
        // Update existing customer
        $klant->update($validated);
    } else {
        // Create a new customer record
        Klant::create($validated);
    }

    return redirect()->route('bestel')->with('success', 'Klantinformatie is succesvol opgeslagen!');
})->name('klant.save');

// Home Route - Displays the homepage
Route::get('/', function () {
    return view('home');
})->name('home');

// Contact Route - Displays the contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Dashboard Route - Requires authentication and email verification


Route::get('/dashboard', function () {
    // Fetch all bestellings with their related bestelregels
    $bestellings = OrderBestelling::with('bestelregels')->get();

    // Pass data to the dashboard view
    return view('dashboard', ['bestellings' => $bestellings]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Login Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');

// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Order Routes
Route::get('/bestel', [PizzaController::class, 'bestel'])->name('bestel'); // Order page
Route::post('/order', [BestelController::class, 'store'])->name('order.store'); // Order submission

// Cart Route - Displays the cart page
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// Image Route - Serves pizza images by ID
Route::get('/pizzas/{id}/image', [ImageController::class, 'show'])->name('pizzas.image');

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Include Authentication Routes (e.g., Register, Forgot Password, etc.)
require __DIR__ . '/auth.php';
