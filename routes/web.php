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

Route::get('/', 'MovieController@index');

Route::get('/movies', 'MovieController@index')->name('movies');

Route::get('/add', 'MovieController@create')->name('add-movie');

Route::post('/store', 'MovieController@store')->name('store-movie');

Route::post('/search', 'MovieController@search')->name('search-movie');