<?php

namespace Database\Factories;

use App\Models\AttributeTemplate;

/**
 * @extends StandardEntityFactory<AttributeTemplate>
 */
class AttributeTemplateFactory extends StandardEntityFactory
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
