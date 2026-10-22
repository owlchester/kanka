<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\Family;

class FamilyFactory extends StandardEntityFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Family::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
