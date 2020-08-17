<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\HotBeanExchange;
use Faker\Generator as Faker;

$factory->define(HotBeanExchange::class, function (Faker $faker) {
    return [
        'hot_user_id' => $faker->randomNumber(),
        'exchange_type' => random_int(1, 2),
        'from_nums' => $faker->randomNumber(),
        'to_nums' => $faker->randomNumber(),
        'service_charge' => $faker->randomFloat(2, 0, 100.23),
    ];
});
