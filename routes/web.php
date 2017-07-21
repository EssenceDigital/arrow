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


 /* API Routes */

Route::post('/api/update-user', 'DashboardController@updateUserInfo');
Route::post('/api/change-personal-password', 'DashboardController@changePersonalPassword');
Route::post('/api/get-logged-in-user', 'DashboardController@getLoggedInUser');

// Dashboard 
Route::get('/api/dashboard/users-projects', 'DashboardController@usersProjects');
Route::get('/api/dashboard/project-timesheets/{projectId}', 'DashboardController@projectTimesheets');

// Timesheets
Route::post('/api/timesheets/create', 'TimesheetsController@store');
Route::post('/api/timesheets/update', 'TimesheetsController@update');
Route::get('/api/timesheets/{id}', 'TimesheetsController@single');
// Work Jobs
Route::post('/api/work-jobs/create', 'WorkJobController@store');
Route::post('/api/work-jobs/update', 'WorkJobController@update');

// Projects
Route::get('/api/projects/all', 'ProjectsController@all');
Route::get('/api/projects/unique-clients', 'ProjectsController@uniqueClients');
Route::get('/api/projects/{id}', 'ProjectsController@single');
Route::post('/api/projects/create', 'ProjectsController@store');
Route::post('/api/projects/update', 'ProjectsController@update');
Route::post('/api/projects/update-field', 'ProjectsController@updateField');
Route::post('/api/projects/delete', 'ProjectsController@delete');
Route::post('/api/projects/add-crew', 'ProjectsController@addCrewMember');
Route::post('/api/projects/remove-crew', 'ProjectsController@RemoveCrewMember');
Route::post('/api/projects/add-comment', 'ProjectsController@addComment');
Route::post('/api/projects/remove-comment', 'ProjectsController@removeComment');

// Proposals
Route::post('/api/proposals/create', 'ProposalsController@store');
Route::post('/api/proposals/update', 'ProposalsController@update');

// Timelines
Route::post('/api/timelines/create', 'TimelinesController@store');
Route::post('/api/timelines/update', 'TimelinesController@update');
Route::post('/api/timelines/update-field', 'TimelinesController@updateField');

// Users
Route::get('/api/users', 'UsersController@hub');
Route::get('/api/users/all', 'UsersController@all');
Route::get('/api/users/all-pages', 'UsersController@allPages');
Route::get('/api/users/{id}', 'UsersController@single');
Route::post('/api/users/create', 'UsersController@store');
Route::post('/api/users/update', 'UsersController@update');
Route::post('/api/users/update-field', 'UsersController@updateField');
Route::post('/api/users/change-password', 'UsersController@changePassword');
Route::post('/api/users/delete', 'UsersController@delete');
Auth::routes();

