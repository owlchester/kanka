<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CommunityVote;
use Faker\Generator as Faker;

$factory->define(CommunityVote::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'content' => $faker->text(),
        'excerpt' => $faker->text(),
        'options' => "{'one': 'option 1', 'two': 'option two'}",
        'published_at' => $faker->dateTimeBetween('now', '-30 days'),
        'visible_at' => $faker->dateTimeBetween('now', '+30 days'),
    ];
});
