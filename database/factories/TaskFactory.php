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
        'due'=>'2021-09-08 19:00',
        'start'=>'2021-09-08 19:00'
    ];
});
