<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzaSeederNoImage extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pizzas = [
            [
                'naam' => 'Margherita',
                'prijs' => 8.50,
                'beschrijving' => 'Classic Margherita pizza with fresh mozzarella and basil.',
            ],
            [
                'naam' => 'Pepperoni',
                'prijs' => 9.00,
                'beschrijving' => 'Delicious Pepperoni pizza with spicy pepperoni and mozzarella.',
            ],
            [
                'naam' => 'Hawaiian',
                'prijs' => 8.75,
                'beschrijving' => 'Tropical Hawaiian pizza with ham, pineapple, and mozzarella.',
            ],
            [
                'naam' => 'Veggie Supreme',
                'prijs' => 10.00,
                'beschrijving' => 'Loaded with fresh vegetables: bell peppers, onions, olives, and mushrooms.',
            ],
            [
                'naam' => 'Quattro Formaggi',
                'prijs' => 11.00,
                'beschrijving' => 'A cheese lover’s dream with four types of cheese: mozzarella, parmesan, gorgonzola, and ricotta.',
            ],
        ];

        DB::table('pizzas')->insert($pizzas);
    }
}
