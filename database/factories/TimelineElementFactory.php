<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\TimelineElement;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimelineElementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimelineElement::class;

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
            'use_event_date' => false,
        ];
    }
}
