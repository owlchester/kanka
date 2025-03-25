<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\MapMarker;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapMarkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MapMarker::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'longitude' => 1,
            'latitude' => 1,
            'icon' => 1,
            'shape_id' => 1,
        ];
    }
}
