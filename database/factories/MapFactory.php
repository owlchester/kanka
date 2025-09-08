<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\Map;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Map::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
        ];
    }
}
