<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\Conversation;

class ConversationFactory extends StandardEntityFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'target_id' => 2,
            'is_private' => false,
        ];
    }
}
