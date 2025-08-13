<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\MapLayer;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapLayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MapLayer::class;

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
