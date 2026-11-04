<?php

namespace Database\Factories;

use App\Models\Whiteboard;

/**
 * @extends StandardEntityFactory<Whiteboard>
 */
class WhiteboardFactory extends StandardEntityFactory
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
        ];
    }
}
