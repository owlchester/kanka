<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\EntityAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityAssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EntityAsset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(10),
            'type_id' => 1,
            'is_pinned' => 0,
            'visibility_id' => 1,
        ];
    }
}
