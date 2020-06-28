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
Route::get('test','TestController@index');
//Route::get('/help', 'TestController@help')->name('help');
//Route::get('/', 'TestController@home')->name('home');
Route::get('signup', 'UsersController@create')->name('signup');
