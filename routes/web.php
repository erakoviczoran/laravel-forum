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

Route::post('/threads', 'ThreadsController@store')->name('threads.store')->middleware('must-be-verified');

Route::get('/threads/{channel}', 'ThreadsController@index')->name('threads.channels');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');

Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy')->name('threads.delete');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index')->name('replies');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('replies.store');

Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.update');

Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.delete');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('favorites.store');

Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('favorites.delete');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profiles.user');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')
     ->name('threadSubscriptions.store');

Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')
     ->name('threadSubscriptions.delete');

Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index')->name('userNotifications');

Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy')
     ->name('userNotifications.delete');

Route::get('/api/users', 'Api\UsersController@index')->name('api.users');

Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->name('api.avatar');
