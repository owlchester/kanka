<?php

namespace Database\Factories;

//use Faker\Generator as Faker;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(20),
            'entry' => '<p>' . fake()->text(500) . '<p>',
            'excerpt' => fake()->text(100),
            'ui_settings' => ['nested' => true],
            'is_featured' => false,
            'entity_visibility' => fake()->boolean(),
            'entity_personality_visibility' => fake()->boolean(),
        ];
    }
}
