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

Route::get('/', 'HomeController@index');

// room
Route::group(['middleware' => 'auth', 'prefix' => 'room'], function () {

    Route::get('create' , 'RoomController@create');
    Route::get('lists' , 'RoomController@lists');
    Route::post('add' , 'RoomController@add');
    Route::get('/{id}/edit' , 'RoomController@edit');
    Route::post('/{id}/update' , 'RoomController@update');
    Route::get('{id}' , 'RoomController@chat');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
