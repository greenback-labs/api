<?php

use Faker\Generator as Faker;
use App\Person;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'name' => substr($faker->name, 1, 100),
        'description' => substr($faker->optional($weight = 0.15)->paragraph(rand(1, 6)), 1, 500)
    ];
});
