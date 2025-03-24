<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\PostTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostTag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => 1,
            'tag_id' => 1,
        ];
    }
}
