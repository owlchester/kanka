<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->word(),
            'name' => fake()->word(),
            'monthly' => fake()->randomFloat(2, 1, 20),
            'yearly' => fake()->randomFloat(2, 10, 100),
            'position' => fake()->numberBetween(1, 10),
        ];
    }
}
