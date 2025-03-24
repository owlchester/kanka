<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\EntityTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EntityTag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entity_id' => 1,
            'tag_id' => 1,
        ];
    }
}
