<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\DiceRoll;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiceRollFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiceRoll::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'parameters' => '2d2',
            'is_private' => false,
        ];
    }
}
