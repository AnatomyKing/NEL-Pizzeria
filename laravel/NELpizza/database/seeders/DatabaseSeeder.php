<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Add your seeders here
        $this->call([
            PizzaSeederNoImage::class,
            IngredientsSeeder::class,
            IngredientPizzaSeeder::class,
        ]);
    }
}