<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Ingredient;

class IngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'naam' => $this->faker->word(),
            'prijs' => $this->faker->randomFloat(2, 0, 999999.99),
        ];
    }
}
