<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\BestelController;
use App\Http\Controllers\PizzaIngredientController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('homepage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/openingstijden', function () {
    return view('openingstijden');
})->name('openingstijden');

Route::get('/home', function () {
    return view('homepage');
})->name('home');

// Pizza Routes
Route::get('/pizza', [PizzaController::class, 'index'])->name('pizza.index');
Route::post('/pizza/add-to-cart/{id}', [PizzaController::class, 'addToCart'])->name('pizza.addToCart');
Route::post('/pizza/update-cart/{id}', [PizzaController::class, 'updateCart'])->name('pizza.updateCart');
Route::delete('/pizza/remove-from-cart/{id}', [PizzaController::class, 'removeFromCart'])->name('pizza.removeFromCart');

// Bestel Routes
Route::get('/bestel', [BestelController::class, 'create'])->name('bestel');
Route::post('/bestel', [BestelController::class, 'store'])->name('bestel.store');
Route::get('/bestel/create', [BestelController::class, 'create'])->name('bestel.create');

Route::get('/options', function () {
    return view('options');
})->name('options');

Route::get('/pizza/{pizza}/edit', [PizzaIngredientController::class, 'edit'])->name('pizza.edit');
Route::post('/pizza/{pizza}/update', [PizzaIngredientController::class, 'update'])->name('pizza.update');

require __DIR__.'/auth.php';
