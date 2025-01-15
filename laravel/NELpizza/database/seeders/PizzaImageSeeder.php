<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzaImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pizzas')->where('naam', 'Hawaii')->update(['image' => 'h.png']);
        DB::table('pizzas')->where('naam', 'Pepperoni')->update(['image' => 'p.png']);
        DB::table('pizzas')->where('naam', 'Margherita')->update(['image' => 'm.png']);
        DB::table('pizzas')->where('naam', 'Quattro Formaggi')->update(['image' => 'q.png']);
        DB::table('pizzas')->where('naam', 'Salami')->update(['image' => 's.png']);
        DB::table('pizzas')->where('naam', 'Funghi')->update(['image' => 'f.png']);
    }
}
