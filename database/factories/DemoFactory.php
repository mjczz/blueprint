<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Demo;
use Faker\Generator as Faker;

$factory->define(Demo::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'desc' => $faker->text,
        'publish_status' => random_int(1, 2),
        'demo_top' => random_int(1, 2),
        'demo_recommend' => random_int(1, 2),
        'sort' => $faker->randomNumber(),
        'published_at' => $faker->dateTime(),
        'demo_score' => $faker->randomFloat(1, 0, 99),
    ];
});
