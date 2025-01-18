<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\BestelController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

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
    return view('dashboard');
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

// Include Authentication Routes (e.g., Register, Forgot Password, etc.)
require __DIR__ . '/auth.php';
