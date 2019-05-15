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

Route::get('/', function () {
    return view('welcome');
});
// USERS MODUL START
Route::get('/users', 'Admin\UsersController@index')->name('users.index');
Route::any('/users/register', 'Admin\UsersController@register')->name('users.register');
Route::any('/users/login', 'Admin\UsersController@login')->name('users.login');
Route::get('/users/welcome', 'Admin\UsersController@welcome')->name('users.welcome');
Route::get('/users/create', 'Admin\UsersController@create')->name('users.create');
Route::post('/users/store', 'Admin\UsersController@store')->name('users.store');
Route::get('/users/logout', 'Admin\UsersController@logout')->name('users.logout');
Route::get('/users/{user}/edit', 'Admin\UsersController@edit')->name('users.edit');
Route::post('/users/{user}/edit', 'Admin\UsersController@update')->name('users.update');
Route::get('/users/{user}/delete', 'Admin\UsersController@delete')->name('users.delete');
Route::get('/users/{user}/changestatus', 'Admin\UsersController@changestatus')->name('users.changestatus');
Route::any('/users/{user}/changepassword', 'Admin\UsersController@changepassword')->name('users.changepassword');
// USERS MODUL END

// ADMISSIONS MODUL START
Route::get('/admissions/create', 'Admin\AdmissionsController@create')->name('admissions.create');
Route::post('/admissions/store', 'Admin\AdmissionsController@store')->name('admissions.store');
Route::get('/admissions', 'Admin\AdmissionsController@index')->name('admissions.index');
Route::get('/admissions/{admission}/edit', 'Admin\AdmissionsController@edit')->name('admissions.edit');
Route::post('/admissions/{admission}/edit', 'Admin\AdmissionsController@update')->name('admissions.update');
Route::get('/admissions/{admission}/delete', 'Admin\AdmissionsController@delete')->name('admissions.delete');
Route::get('/admissions/{admission}/changestatus', 'Admin\AdmissionsController@changestatus')->name('admissions.changestatus');
// ADMISSIONS MODUL END

// INTERVIEWS MODUL START
Route::get('/interviews/create', 'Admin\InterviewsController@create')->name('interviews.create');
Route::get('/interviews/show', 'Admin\InterviewsController@show')->name('interviews.show');
Route::post('/interviews/ajaxReq', 'Admin\InterviewsController@ajaxReq')->name('interviews.ajaxReq');
Route::post('/interviews/store', 'Admin\InterviewsController@store')->name('interviews.store');
Route::get('/interviews', 'Admin\InterviewsController@index')->name('interviews.index');
Route::get('/interviews/interviews', 'Admin\InterviewsController@interviews')->name('interviews.interviews');
Route::get('/interviews/{interview}/edit', 'Admin\InterviewsController@edit')->name('interviews.edit');
Route::post('/interviews/{interview}/edit', 'Admin\InterviewsController@update')->name('interviews.update');
Route::post('/interviews/{interview}/changestatus', 'Admin\InterviewsController@changestatus')->name('interviews.changestatus');
// INTERVIEWS MODUL END