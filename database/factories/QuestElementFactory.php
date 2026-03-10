<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\QuestElement;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestElementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestElement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'entry' => '<p>' . fake()->text(50) . '<p>',
        ];
    }
}
