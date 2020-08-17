<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\HotPublishOrder;
use App\Models\HotUser;
use Faker\Generator as Faker;

$factory->define(HotPublishOrder::class, function (Faker $faker) {
    $maxId = HotUser::query()->orderBy('id', 'desc')->limit(1)->get()[0]['id'];

    return [
        'lock_status' => random_int(1, 2),
        'order_type' => random_int(1, 2),
        'order_amount_type' => random_int(1, 2, 3),
        'nums' => random_int(10, 20),
        'frozen_nums' => 0,
        'price' => $faker->randomFloat(2, 0, 99999999.99),
        'hot_user_id' => random_int(1, $maxId),
        'sales_service_charge' => $faker->randomFloat(2, 0, 99999999.99),
        'secret' => $faker->numberBetween(1, 100),
    ];
});
