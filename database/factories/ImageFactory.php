<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'name' => fake()->text(10),
            'ext' => 'png',
            'size' => 209,
            'is_default' => 0,
            'folder_id' => null,
            'is_folder' => 0,
            'visibility_id' => 1,

        ];
    }
}
