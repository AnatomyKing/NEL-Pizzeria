<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function bestel()
    {
        $pizzas = Pizza::all();
        return view('bestel', compact('pizzas'));
    }
}
