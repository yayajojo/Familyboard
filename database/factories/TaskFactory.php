<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'project_id'=>factory('App\Project'),
        'body'=>$faker->sentence,
        'completed'=>false,
        'due'=>Carbon::now()->addDays(1),
        'start'=>Carbon::now()
    ];
});
