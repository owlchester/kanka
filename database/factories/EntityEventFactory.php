<?php

namespace Database\Factories;

//use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EntityEvent;

class EntityEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EntityEvent::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'calendar_id' => 1,
            'day' => 2,
            'month' => 2,
            'year' => 2,
            'length' => 2,
            'visibility_id' => 1,
            ];
    }
}
