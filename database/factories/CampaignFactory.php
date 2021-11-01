<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Campaign;
use Faker\Generator as Faker;

$factory->define(Campaign::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'visibility_id' => $faker->boolean(),
        'visible_entity_count' => $faker->randomDigitNotZero(),
        'entry' => $faker->text(),
        'excerpt' => $faker->text(),
        'entity_visibility' => 1,
        'is_featured' => $faker->boolean(),
        'entity_personality_visibility' => 1,
        'locale' => 'en',
    ];
});
