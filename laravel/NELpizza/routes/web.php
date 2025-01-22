<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BestelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CartController;

// Public home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');


// Show the pizza bestel page
Route::get('/bestel', [PizzaController::class, 'bestel'])->name('bestel');

// POST to place an order
Route::post('/bestel', [BestelController::class, 'store'])->name('bestelling.store');

// Cart page
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// Route to serve pizza image
Route::get('/pizza-image/{id}', [ImageController::class, 'show'])->name('pizza.image');

// ----------------------------------------------------------------
// Protected routes - require auth
// ----------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'edit'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'update'])->name('dashboard.update');
});


// ----------------------------------------------------------------
// Include the default Breeze routes (auth.php) if desired
// ----------------------------------------------------------------
require __DIR__.'/auth.php';
