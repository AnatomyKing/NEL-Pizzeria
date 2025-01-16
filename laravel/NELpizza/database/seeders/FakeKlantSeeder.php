<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klant;

class FakeKlantSeeder extends Seeder
{
    public function run()
    {
        // Create or update a "fake" klant with ID=999
        Klant::updateOrCreate(
            ['id' => 999],
            [
                'naam'          => 'Fake Customer',
                'adres'         => '123 Fake Street',
                'woonplaats'    => 'Faketown',
                'telefoonnummer'=> '0000000000',
                'emailadres'    => 'fake@example.com',
            ]
        );
    }
}
