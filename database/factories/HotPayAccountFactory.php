<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\HotPayAccount;
use App\Models\HotUser;
use Faker\Generator as Faker;

$factory->define(HotPayAccount::class, function (Faker $faker) {
    return [
        'account_type' => random_int(1, 2),
        'account' => $faker->bankAccountNumber,
        'account_name' => $faker->randomElement(['中国银行', '工商银行']),
        'hot_user_id' => random_int(1, 10)
    ];
});
