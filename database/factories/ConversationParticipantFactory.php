<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\ConversationParticipant;
use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationParticipantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConversationParticipant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'participant_type' => Entity::class,
            'participant_id' => 1,
        ];
    }
}
