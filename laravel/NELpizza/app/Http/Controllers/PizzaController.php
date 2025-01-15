<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function home()
    {
        $pizzas = Pizza::all();
        return view('home', compact('pizzas'));
    }
}
