<?php

namespace Database\Factories;

//use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Relation;

class RelationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Relation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'relation' => fake()->text(10),
        ];
    }
}
