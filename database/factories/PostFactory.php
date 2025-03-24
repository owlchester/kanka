<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'entry' => '<p>' . fake()->text(500) . '<p>',
            'position' => 1,
        ];
    }
}
