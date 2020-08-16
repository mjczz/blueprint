<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'content' => $faker->paragraphs(3, true),
        'publish_status' => random_int(1, 2),
        'news_top' => random_int(1, 2),
        'news_recommend' => random_int(1, 2),
        'news_type' => random_int(1, 2),
        'sort' => $faker->randomDigitNotNull,
        'published_at' => $faker->dateTime(),
    ];
});
