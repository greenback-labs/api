<?php

use Faker\Generator as Faker;
use App\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(rand(2, 6)),
        'description' => $faker->optional($weight = 0.3)->paragraph(rand(1, 6))
    ];
});
