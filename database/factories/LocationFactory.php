<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\Location;

class LocationFactory extends StandardEntityFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'is_private' => false,
        ];
    }
}
