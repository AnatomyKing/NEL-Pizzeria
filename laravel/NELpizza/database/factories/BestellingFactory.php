<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bestelling;
use App\Models\Klant;
use App\Models\Pizza;

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
            'status' => $this->faker->randomElement(["besteld","bereiden","inoven","uitoven","onderweg","bezorgd","geannuleerd"]),
            'klant_id' => Klant::factory(),
            'pizza_id' => Pizza::factory(),
        ];
    }
}
