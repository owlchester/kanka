<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\CampaignStyle;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignStyleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CampaignStyle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'content' => fake()->text(50),
            'is_enabled' => false,
            'is_theme' => false,
        ];
    }
}
