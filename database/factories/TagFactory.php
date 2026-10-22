<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\Tag;

class TagFactory extends StandardEntityFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'is_hidden' => 0,
        ];
    }
}
