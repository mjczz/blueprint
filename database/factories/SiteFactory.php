<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Site;
use Faker\Generator as Faker;

$factory->define(Site::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'keywords' => $faker->word,
        'desc' => $faker->text,
        'copyright' => $faker->word,
        'icp' => $faker->word,
        'external_traffic' => $faker->text,
    ];
});
