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
Route::get('/bestel', [PizzaController::class, 'bestel'])->name('bestel');

// Home route -> calls PizzaController@home

// Contact route -> just shows a contact page
Route::get('/contact', function () {
    return view('contact'); 
})->name('contact');

// Dashboard route -> requires auth/verified
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return view('home'); 
})->name('home');

// POST form submission for orders
//Route::post('/bestel', [BestelController::class, 'store'])->name('bestel.store');
Route::post('/order', [BestelController::class, 'store'])->name('order.store');

// (Optional) If you serve images from a controller
Route::get('/pizzas/{id}/image', [ImageController::class, 'show'])->name('pizzas.image');
Route::get('/cart', function () {
    return view('cart'); 
})->name('cart');
// If you have Laravel Breeze or other Auth routes
require __DIR__.'/auth.php';

