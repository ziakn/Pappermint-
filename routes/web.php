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
Route::get('/dashboard', function () {
    return view('dashboard');
});

Auth::routes();
//resources
Route::resource('/app/user', 'UserController');
//setting
Route::post('/app/updateUser','UserController@updateUser');
Route::get('/app/profile', 'UserController@profile');
Route::post('/app/changepassword', 'UserController@changePass');
//Staff
Route::post('/app/login', 'UserController@login');
Route::get('/app/auth', 'UserController@profile')->middleware('auth:api');
Route::post('/app/staff/complete', 'Staff\StaffController@complete')->middleware('auth:api');
Route::post('/app/staff/updateagent', 'Staff\StaffController@updateAgent');

//staff resources

Route::get('/app/map/{string}', 'MapController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::any('/dashboard/{slug}', [
    'uses' => 'HomeController@dashboard',
 ]);
 Route::any('/staff/{slug}', [
    'uses' => 'HomeController@staff',
 ]);
 Route::get('/staff', function () {
    return view('staff');
});
