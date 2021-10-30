<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CommunityEvent;
use Faker\Generator as Faker;

$factory->define(CommunityEvent::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'entry' => $faker->text(),
        'excerpt' => $faker->text(),

        'start_at' => $faker->dateTime('now'),
        'ends_at' => $faker->dateTimeBetween('+10 days', '+20 days'),
    ];
});
