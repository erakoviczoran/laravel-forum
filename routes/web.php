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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/threads', 'ThreadsController@index')->name('threads');

Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');

Route::post('/threads', 'ThreadsController@store')->name('threads.store');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');

Route::post('/threads/{thread}/replies', 'RepliesController@store')->name('threads.replies');
