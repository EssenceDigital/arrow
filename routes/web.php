<?php

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

// Site Routes
Route::get('/', 'SiteController@index');
Route::get('/services', 'SiteController@services');
Route::get('/profile', 'SiteController@profile');
Route::get('/projects', 'SiteController@projects');
Route::get('/team', 'SiteController@team');

// App Routes

Route::get('/app', 'DashboardController@index');

// Projects
Route::get('/app/projects', 'ProjectsController@hub');
Route::post('/app/projects/create', 'ProjectsController@store');

// Users
Route::get('/app/users', 'UsersController@hub');
Route::get('/app/users/all', 'UsersController@all');
Route::get('/app/users/{id}', 'UsersController@single');
Route::post('/app/users/create', 'UsersController@store');
Route::post('/app/users/update', 'UsersController@update');
Route::post('/app/users/change-password', 'UsersController@changePassword');
Route::post('/app/users/delete', 'UsersController@delete');
Auth::routes();
