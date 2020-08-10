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
        Route::post('/project', 'ProjectController@store')->name('project.store');
        Route::get('/project', 'ProjectController@index')->name('project.index');
        Route::get('/project/create','ProjectController@create')->name('project.create');
        Route::get('/project/{project}','ProjectController@show')->name('project.show');
        Route::get('/home', 'HomeController@index')->name('home');
    }
);


