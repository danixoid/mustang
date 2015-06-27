<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//ДЛЯ ГОСТЕЙ
Route::get('/', 'WelcomeController@index');



//ДЛЯ ПОЛЬЗОВАТЕЛЕЙ
Route::get('home', 'HomeController@index');

//ДЛЯ АКТИВИРОВАННЫХ ПОЛЬЗОВАТЕЛЕЙ
Route::get('map', 'WorkController@getMap');

Route::get('cargo', ['as' => 'cargo.list', 'uses' => 'CargoController@index']);
Route::get('cargo/add', ['as' => 'cargo.add', 'uses' => 'CargoController@create']);
Route::get('cargo/{id}', ['as' => 'cargo.show', 'uses' => 'CargoController@show']);
Route::get('cargo/{id}/edit', ['as' => 'cargo.edit', 'uses' => 'CargoController@edit']);

Route::post('cargo/{id}/update', ['as' => 'cargo.update', 'uses' => 'CargoController@update']);
Route::post('cargo/{id}/delete', ['as' => 'cargo.delete', 'uses' => 'CargoController@destroy']);



Route::get('distance', 'WorkController@getDistance');


//ДЛЯ МОБИЛЬНОГО ПРИЛОЖЕНИЯ И AJAX-ЗАПРОСОВ
Route::any('profile','JsonController@index');
Route::post('findtruck','JsonController@inRadius');


//АВТОРИЗАЦИЯ
Route::controllers([
	'auth'      => 'Auth\AuthController',
	'password'  => 'Auth\PasswordController',
]);

//TESTING
#Route::get('/getuser', 'WelcomeController@getuser');
#Route::get('/', array('https','WelcomeController@index'));
