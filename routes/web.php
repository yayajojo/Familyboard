<?php

use App\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

Route::get('/', function(){
    return view('auth/register');
})->middleware('redirecttoprojects');
Auth::routes();
Route::middleware(['auth'])->group(
    function () {
        Route::post('/projects', 'ProjectController@store')->name('project.store');
        Route::patch('projects/{project}', 'ProjectController@update')->name('project.update');
        Route::delete('projects/{project}', 'ProjectController@destory')->name('project.destory');
        Route::get('/projects', 'ProjectController@index')->name('project.index');
        Route::get('/projects/create', 'ProjectController@create')->name('project.create');
        Route::get('/projects/{project}', 'ProjectController@show')->name('project.show');
        Route::get('/projects/{project}/edit', 'ProjectController@edit')->name('project.edit');
        Route::get('/home', 'HomeController@index')->name('home');
    }
);

Route::middleware(['auth'])->group(
    function () {
        Route::patch('/projects/{project}/tasks/{task}', 'TaskController@update')->name('task.update');
        Route::post('/projects/{project}/tasks', 'TaskController@store')->name('task.store');
        Route::get('/projects/{project}/tasks/{task}/edit', 'TaskController@edit')->name('task.edit');
    }
);


Route::middleware(['auth'])->group(
    function () {
        Route::post('/projects/{project}/invitations', 'ProjectInvitationController@store')->name('invitation.store');
        Route::get('/member/id', function () {
            return Auth::id();
        });
    }
);

Route::middleware(['auth'])->group(
    function(){
        Route::get('/profiles/create','ProfileController@create')->name('profile.create');
        Route::post('/profiles','ProfileController@store')->name('profile.store');
    }
);