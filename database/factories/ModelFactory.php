<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Restaurant::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'delivery_time' => $faker->randomNumber(4, false),
    ];
});

$factory->afterCreating(App\Restaurant::class, function ($restaurant, $faker) {
    $restaurant->messages()->saveMany(factory(App\Message::class, $faker->numberBetween(0, 3))->make());
});

$factory->define(App\Message::class, function (Faker\Generator $faker) {
    return [
        'body' => $faker->sentence(),
        'status' => $faker->randomElement(array('delivered', 'error')),
    ];
});
