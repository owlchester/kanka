<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\EntityAbility;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityAbilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EntityAbility::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'charges' => rand(0, 100),
        ];
    }
}
