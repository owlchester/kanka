<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attribute::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'value' => rand(500, 5000),
            'type_id' => 1,
            'api_key' => '1',
            'is_hidden' => 0,
            'is_private' => 0,
        ];
    }
}
