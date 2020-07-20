<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'content' => $faker->paragraphs(3, true),
        'publish_status' => $faker->randomDigitNotNull,
        'news_top' => $faker->randomDigitNotNull,
        'news_recommend' => $faker->randomDigitNotNull,
        'news_type' => $faker->randomDigitNotNull,
        'sort' => $faker->randomDigitNotNull,
        'published_at' => $faker->dateTime(),
    ];
});
