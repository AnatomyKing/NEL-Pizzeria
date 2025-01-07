<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bestelling;
use App\Models\Klanten;

class BestellingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bestelling::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'datum' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement(["initieel","betaald","bereiden","inoven","onderweg","bezorgd"]),
            'klant_id' => Klanten::factory(),
        ];
    }
}
