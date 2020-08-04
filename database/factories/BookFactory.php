<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'bookCode' => $faker->md5,
        'title' => $faker->word,
        'infoLink' => $faker->url,
        'authors' => $faker->name,
        'publishedDate' => $faker->date(),
        'pageCount' => $faker->randomDigit,
        'description' => $faker->sentence,
        'thumbnail' => $faker->imageUrl(),
    ];
});
