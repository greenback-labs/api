<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->optional($weight = 0.15)->paragraph(rand(1, 6))
    ];
});
