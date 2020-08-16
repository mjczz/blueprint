<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\HotUser;
use Faker\Generator as Faker;

$factory->define(HotUser::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'mobile' => $faker->phoneNumber,
        'app_user_id' => $faker->randomNumber(),
        'red_bean_nums' => $faker->randomNumber(),
        'hot_bean_nums' => $faker->randomNumber(),
        'frozen_hot_bean_nums' => $faker->randomNumber(),
        'hot_user_status' => random_int(1, 2),
    ];
});
