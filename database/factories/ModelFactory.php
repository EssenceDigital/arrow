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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password = 'cubanlink';

    return [
        'first' => "Rand",
        'last' => "al'Thor",
        'permissions' => 'admin',
        'email' => 'rand@admin.ca',
        'company_name' => "Asha'man",
        'hourly_rate_one' => 100.00,
        'gst_number' => 'A458EHE5'
        'password' => bcrypt($password)
    ];
});
