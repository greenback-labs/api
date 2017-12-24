<?php

use Faker\Generator as Faker;
use App\Transaction;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'type' =>  $faker->randomElement(['in', 'out']),
        'value' => $faker->optional($weight = 0.95, $default = $faker->randomFloat(2, 500, 10000))->randomFloat(2, 0.01, 500),
        'title' => $faker->sentence(rand(2, 6)),
        'description' => $faker->optional($weight = 0.5)->paragraph(rand(1, 6)),
        'date' => ? $faker->date()
    ];
});
