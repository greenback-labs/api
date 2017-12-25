<?php

use Faker\Generator as Faker;
use App\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => substr($faker->sentence(rand(2, 6)), 1, 50),
        'description' => substr($faker->optional($weight = 0.3)->paragraph(rand(1, 6)), 1, 500)
    ];
});
