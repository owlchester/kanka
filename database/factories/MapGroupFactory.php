<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\MapGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MapGroup::class;

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
