<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bestelling;
use App\Models\Bestelregel;
use App\Models\Pizza;
use App\Models\PizzaBestelling;

class BestelregelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bestelregel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'aantal' => $this->faker->numberBetween(-10000, 10000),
            'afmeting' => $this->faker->randomElement(["klein","normaal","groot"]),
            'pizza_id' => Pizza::factory(),
            'bestelling_id' => Bestelling::factory(),
            'pizza_bestelling_id' => PizzaBestelling::factory(),
        ];
    }
}
