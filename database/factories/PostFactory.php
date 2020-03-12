<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
//        'thumbnail_comment' => 'unko',
//        'main_content' => 'untyokohfghgggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggh',
//        'post_state' => 1,
        'main_content' => $faker->paragraph,
        'thumbnail_comment' => $faker->sentence,
        'post_state' => $faker->numberBetween(1,3),
    ];
});
