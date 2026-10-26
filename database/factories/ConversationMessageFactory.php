<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\ConversationMessage;
use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConversationMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message' => fake()->text(20),
            'participant_type' => Entity::class,
            'participant_id' => 1,
        ];
    }
}
