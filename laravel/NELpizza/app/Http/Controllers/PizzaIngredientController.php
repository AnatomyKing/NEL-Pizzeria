<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class PizzaIngredientController extends Controller
{
    /**
     * Toon de pagina voor het bewerken van ingrediënten van een specifieke pizza.
     *
     * @param int $pizzaId
     * @return \Illuminate\View\View
     */
    public function edit($pizzaId)
    {
        // Haal de pizza op inclusief gekoppelde ingrediënten
        $pizza = Pizza::with('ingredients')->findOrFail($pizzaId);

        // Haal alle beschikbare ingrediënten op
        $allIngredients = Ingredient::all();

        // Retourneer de view met pizza en alle ingrediënten
        return view('pizza.edit', compact('pizza', 'allIngredients'));
    }

    /**
     * Werk de ingrediënten bij voor een specifieke pizza.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $pizzaId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $pizzaId)
    {
        // Validatie van het request
        $request->validate([
            'ingredients' => 'nullable|string',
        ]);

        // Haal de pizza op
        $pizza = Pizza::findOrFail($pizzaId);

        // Ontvang de geselecteerde ingrediënten als een array
        $ingredientIds = $request->ingredients ? explode(',', $request->ingredients) : [];

        // Update de koppelingen in de database
        $pizza->ingredients()->sync($ingredientIds);

        // Redirect terug met een succesbericht
        return redirect()->route('pizza.edit', $pizzaId)->with('success', 'Ingrediënten succesvol bijgewerkt!');
    }
}
