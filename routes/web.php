<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::middleware(['auth'])->group(
    function(){
        Route::post('/projects', 'ProjectController@store')->name('project.store');
        Route::get('/projects', 'ProjectController@index')->name('project.index');
        Route::get('/projects/create','ProjectController@create')->name('project.create');
        Route::get('/projects/{project}','ProjectController@show')->name('project.show');
        Route::get('/home', 'HomeController@index')->name('home');
    }
);

Route::middleware(['auth'])->group(
    function(){
        Route::post('/projects/{project}/tasks','TaskController@store')->name('task.store');
    }
);


