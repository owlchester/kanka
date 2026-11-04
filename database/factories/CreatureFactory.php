<?php

namespace Database\Factories;

use App\Models\Creature;

/**
 * @extends StandardEntityFactory<Creature>
 */
class CreatureFactory extends StandardEntityFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'is_private' => false,
        ];
    }
}
