<?php

use Faker\Generator as Faker;
use App\Account;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'title' => substr($faker->sentence(rand(2, 6)), 1, 50),
        'description' => substr($faker->optional($weight = 0.25)->paragraph(rand(1, 6)), 1, 500)
    ];
});
