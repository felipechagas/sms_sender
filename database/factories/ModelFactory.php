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
    $date = $faker->dateTimeThisMonth('now', 'UTC');

    return [
        'body' => "Take Away: Your order on ".$faker->company.
            " was received.The estimated delivery time is ".
            $faker->randomNumber(2, false)." minutes.",
        'status' => $faker->randomElement(array('delivered', 'error')),
        'phone_number' => $faker->e164PhoneNumber(),
        'type' => $faker->randomElement(array('before', 'after')),
        'updated_at' => $date,
        'created_at' => $date,
    ];
});
