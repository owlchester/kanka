<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\TimelineEra;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimelineEraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimelineEra::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'entry' => '<p>' . fake()->text(500) . '<p>',
        ];
    }
}
