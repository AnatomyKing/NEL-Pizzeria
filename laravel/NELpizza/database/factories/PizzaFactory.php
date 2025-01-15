<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Pizza;

class PizzaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pizza::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'naam' => $this->faker->word(),
            'prijs' => $this->faker->randomFloat(2, 0, 999999.99),
            'beschrijving' => $this->faker->text(),
        ];
    }
}
