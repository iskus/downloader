<?php

use Faker\Generator as Faker;

$factory->define(App\Target::class, function (Faker $faker) {
    return [
        'link' => $faker->imageUrl(),
    ];
});
