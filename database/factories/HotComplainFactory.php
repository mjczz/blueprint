<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\HotComplain;
use Faker\Generator as Faker;

$factory->define(HotComplain::class, function (Faker $faker) {
    return [
        'hot_user_id' => $faker->randomNumber(),
        'order_id' => $faker->randomNumber(),
        'complain_type' => random_int(1, 3),
        'complain_status' => random_int(1, 2),
        'content' => $faker->paragraphs(3, true),
        'content_pic' => $faker->url,
    ];
});
