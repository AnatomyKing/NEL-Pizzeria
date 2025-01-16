<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['naam' => 'Tomato Sauce', 'prijs' => 0.50],
            ['naam' => 'Cheese', 'prijs' => 1.00],
            ['naam' => 'Mozzarella', 'prijs' => 1.20],
            ['naam' => 'Pepperoni', 'prijs' => 1.50],
            ['naam' => 'Mushrooms', 'prijs' => 0.80],
            ['naam' => 'Bell Peppers', 'prijs' => 0.70],
            ['naam' => 'Onions', 'prijs' => 0.60],
            ['naam' => 'Black Olives', 'prijs' => 0.90],
            ['naam' => 'Ham', 'prijs' => 1.30],
            ['naam' => 'Pineapple', 'prijs' => 0.90],
            ['naam' => 'Bacon', 'prijs' => 1.50],
            ['naam' => 'Grilled Chicken', 'prijs' => 1.80],
            ['naam' => 'Spinach', 'prijs' => 0.75],
            ['naam' => 'Artichokes', 'prijs' => 1.00],
            ['naam' => 'Parmesan', 'prijs' => 1.10],
        ];

        DB::table('ingredients')->insert($ingredients);
    }
}
