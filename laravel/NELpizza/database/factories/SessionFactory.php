<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Session;
use App\Models\User;

class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Session::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ip_address' => $this->faker->word(),
            'user_agent' => $this->faker->text(),
            'payload' => $this->faker->text(),
            'last_activity' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
