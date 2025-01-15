<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzaSeeder extends Seeder
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
                'image' => $this->getImageData('m.png'),
            ],
            [
                'naam' => 'Pepperoni',
                'prijs' => 9.00,
                'beschrijving' => 'Delicious Pepperoni pizza with spicy pepperoni and mozzarella.',
                'image' => $this->getImageData('p.png'),
            ],
            [
                'naam' => 'Hawaiian',
                'prijs' => 8.75,
                'beschrijving' => 'Tropical Hawaiian pizza with ham, pineapple, and mozzarella.',
                'image' => $this->getImageData('h.png'),
            ],
            [
                'naam' => 'Veggie Supreme',
                'prijs' => 10.00,
                'beschrijving' => 'Loaded with fresh vegetables: bell peppers, onions, olives, and mushrooms.',
                'image' => $this->getImageData('f.png'),
            ],
            [
                'naam' => 'Quattro Formaggi',
                'prijs' => 11.00,
                'beschrijving' => 'A cheese lover’s dream with four types of cheese: mozzarella, parmesan, gorgonzola, and ricotta.',
                'image' => $this->getImageData('q.png'),
            ],
        ];

        DB::table('pizzas')->insert($pizzas);
    }

    /**
     * Get the binary image data for the specified file name.
     *
     * @param string $fileName
     * @return string|null
     */
    private function getImageData(string $fileName): ?string
    {
        $filePath = public_path("images/{$fileName}");
        return file_exists($filePath) ? file_get_contents($filePath) : null;
    }
}
