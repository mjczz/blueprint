<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'content' => $faker->paragraphs(3, true),
        'publish_status' => rand(0,1),
        'news_top' => rand(0,1),
        'news_recommend' =>  rand(0,1),
        'news_type' =>  rand(0,1),
        'sort' => rand(1,100),
        'published_at' => date("Y-m-d H:i:s"),
    ];
});
