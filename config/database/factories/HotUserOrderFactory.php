<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\HotUserOrder;
use Faker\Generator as Faker;

$factory->define(HotUserOrder::class, function (Faker $faker) {
    return [
        'publish_order_id' => $faker->randomNumber(),
        'order_no' => $faker->word,
        'order_type' => $faker->randomDigitNotNull,
        'order_status' => $faker->randomDigitNotNull,
        'order_amount_type' => $faker->randomDigitNotNull,
        'nums' => $faker->randomNumber(),
        'price' => $faker->randomFloat(2, 0, 99999999.99),
        'amount' => $faker->randomFloat(2, 0, 99999999.99),
        'hot_user_id' => $faker->randomNumber(),
        'lock_time' => $faker->dateTime(),
        'pay_time' => $faker->dateTime(),
        'confirm_time' => $faker->dateTime(),
        'pay_attach' => $faker->text,
    ];
});
