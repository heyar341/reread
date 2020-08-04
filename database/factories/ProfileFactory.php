<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'intro_self' => $faker->sentence,
        'prof_url' => $faker->url,
    ];
});
