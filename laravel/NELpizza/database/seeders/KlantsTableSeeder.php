<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import the DB facade

class KlantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert dummy data into the klants table
        DB::table('klants')->insert([
            [
                'naam' => 'Laravel Man1',
                'adres' => '123 Pizza Street',
                'woonplaats' => 'PizzaTown',
                'telefoonnummer' => '1234567890',
                'emailadres' => 'john.doe@example.com',
            ],
            [
                'naam' => 'Laravel Man2',
                'adres' => '456 Pasta Avenue',
                'woonplaats' => 'NoodleCity',
                'telefoonnummer' => '0987654321',
                'emailadres' => 'jane.smith@example.com',
            ],
        ]);
    }
}
