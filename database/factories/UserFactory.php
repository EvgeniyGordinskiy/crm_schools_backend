<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

function getReferenceId(string $model): int
{
    $class = '\App\Models\\'.$model;
    if($ids = $class::all('id')->toArray()){
        return array_random($ids)['id'];
    }
    return false;
}

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;
    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

// School
$factory->define(App\Models\School::class, function (Faker $faker) {
    return [
        'name' =>  $faker->word,
        'owner' => getReferenceId('User')
    ];
});

// Programs
$factory->define(App\Models\Program::class, function (Faker $faker) {
    return [
        'name'  =>  $faker->word,
    ];
});

// SchoolPrograms
$factory->define(App\Models\SchoolPrograms::class, function (Faker $faker) {
    return [
        'school_id'  =>  getReferenceId('School'),
        'program_id' => getReferenceId('Program')
    ];
});

// Attendance
$factory->define(App\Models\Attendance::class, function (Faker $faker) {
    return [
        'program_id'  =>  getReferenceId('Program'),
        'user_id' => getReferenceId('User'),
        'presenceFlag' => random_int(0, 1),
        'created_at' => $faker->dateTimeBetween('now', '30 days'),
    ];
});

// Schedules
$factory->define(App\Models\Schedule::class, function (Faker $faker) {
    return [
        'program_id'  =>  getReferenceId('Program'),
        'begin_at' => $faker->dateTimeBetween('now', '30 days'),
        'end_at' => random_int(0, 1) ? $faker->dateTimeBetween('+ 30 days', '60 days') : null,
        'event_name' => $faker->sentence(2)
    ];
});

// Membership
$factory->define(App\Models\Membership::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});


// UserMembership
$factory->define(App\Models\UserMembership::class, function (Faker $faker) {
    return [
        'user_id'  =>  getReferenceId('User'),
        'membership_id' => getReferenceId('Membership')
    ];
});

// GrantType
$factory->define(App\Models\GrantType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});

// Grant
$factory->define(App\Models\Grant::class, function (Faker $faker) {
    return [
        'grant_type_id'  =>  getReferenceId('GrantType'),
        'model_name'  => $faker->word,
    ];
});
