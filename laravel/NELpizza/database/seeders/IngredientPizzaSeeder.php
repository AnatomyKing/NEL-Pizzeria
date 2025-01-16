<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientPizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredientPizza = [
            ['pizza_id' => 1, 'ingredient_id' => 1], // Margherita -> Tomato Sauce
            ['pizza_id' => 1, 'ingredient_id' => 3], // Margherita -> Mozzarella
            ['pizza_id' => 1, 'ingredient_id' => 4], // Margherita -> Basil

            ['pizza_id' => 2, 'ingredient_id' => 1], // Pepperoni -> Tomato Sauce
            ['pizza_id' => 2, 'ingredient_id' => 3], // Pepperoni -> Mozzarella
            ['pizza_id' => 2, 'ingredient_id' => 4], // Pepperoni -> Pepperoni

            ['pizza_id' => 3, 'ingredient_id' => 1], // Hawaiian -> Tomato Sauce
            ['pizza_id' => 3, 'ingredient_id' => 3], // Hawaiian -> Mozzarella
            ['pizza_id' => 3, 'ingredient_id' => 9], // Hawaiian -> Ham
            ['pizza_id' => 3, 'ingredient_id' => 10], // Hawaiian -> Pineapple

            ['pizza_id' => 4, 'ingredient_id' => 5], // Veggie Supreme -> Bell Peppers
            ['pizza_id' => 4, 'ingredient_id' => 6], // Veggie Supreme -> Mushrooms
            ['pizza_id' => 4, 'ingredient_id' => 7], // Veggie Supreme -> Onions
            ['pizza_id' => 4, 'ingredient_id' => 8], // Veggie Supreme -> Black Olives

            ['pizza_id' => 5, 'ingredient_id' => 3], // Quattro Formaggi -> Mozzarella
            ['pizza_id' => 5, 'ingredient_id' => 14], // Quattro Formaggi -> Parmesan
            ['pizza_id' => 5, 'ingredient_id' => 15], // Quattro Formaggi -> Gorgonzola
            ['pizza_id' => 5, 'ingredient_id' => 16], // Quattro Formaggi -> Ricotta
        ];

        DB::table('ingredient_pizza')->insert($ingredientPizza);
    }
}
