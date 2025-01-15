<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\BestelController;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home route -> calls PizzaController@home
Route::get('/', [PizzaController::class, 'home'])->name('home');

// Contact route -> just shows a contact page
Route::get('/contact', function () {
    return view('contact'); 
})->name('contact');

// Dashboard route -> requires auth/verified
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/bestel', function () {
    return view('bestel'); 
})->name('bestel');

// POST form submission for orders
//Route::post('/bestel', [BestelController::class, 'store'])->name('bestel.store');

// (Optional) If you serve images from a controller
Route::get('/pizzas/{pizzaId}/image', [ImageController::class, 'show']);

// If you have Laravel Breeze or other Auth routes
require __DIR__.'/auth.php';
