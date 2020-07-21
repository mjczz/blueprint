<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Movie;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'desc' => $faker->text,
        'publish_status' => random_int(1, 2),
        'movie_top' => random_int(1, 2),
        'movie_recommend' => random_int(1, 2),
        'movie_hot' => random_int(1, 2),
        'sort' => random_int(1, 100),
        'published_at' => $faker->dateTime(),
        'view_num' => $faker->randomNumber(),
        'score' => $faker->randomFloat(1, 0, 99),
    ];
});
