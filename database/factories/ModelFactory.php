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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'is_patient' => rand (0, 1)
    ];
});

$factory->defineAs(App\User::class, 'admin', function () {
    return [
        'name' => 'Admin',
        'email' => 'admin@crossover.com',
        'password' => bcrypt("123456"),
        'remember_token' => str_random(10),
        'is_patient' => 0
    ];
});

$factory->define(App\Report::class, function (Faker\Generator $faker) {
    $patients = App\User::where ('is_patient', 1)->get(['id']);
    return [
        'patient_id' => pick_one($patients),
        'notes' => $faker->sentence(12, true),
    ];
});

$factory->define(App\Test::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Test #'.($faker->unique()->randomDigit + 1),
        'notes' => $faker->sentence(6, true),
        'enabled' => 1,
    ];
});

$factory->define(App\ReportTest::class, function (Faker\Generator $faker) {
    $reports = App\Report::get(['id']);
    $tests = App\Test::get(['id']);
    return [
        'report_id' => pick_one($reports),
        'test_id' => pick_one($tests),
        'result' => ["OK", "NO OK"][rand (0,1)]
    ];
});

function pick_one($list)
{
    $array = $list->toArray();
    return $array[rand (0, count ($array) - 1)]['id'];
}