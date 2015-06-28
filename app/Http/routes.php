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

//ДЛЯ АКТИВИРОВАННЫХ АККАУНТОВ ПОЛЬЗОВАТЕЛЕЙ

Route::get('cargo', ['as' => 'cargo.list', 'uses' => 'CargoController@index']);
Route::get('cargo/create', ['as' => 'cargo.create', 'uses' => 'CargoController@create']);
Route::get('cargo/{id}', ['as' => 'cargo.show', 'uses' => 'CargoController@show']);
Route::get('cargo/{id}/edit', ['as' => 'cargo.edit', 'uses' => 'CargoController@edit']);

Route::post('cargo/store', ['as' => 'cargo.store', 'uses' => 'CargoController@store']);
Route::post('cargo/{id}/update', ['as' => 'cargo.update', 'uses' => 'CargoController@update']);
Route::post('cargo/{id}/destroy', ['as' => 'cargo.destroy', 'uses' => 'CargoController@destroy']);

Route::get('map', 'WorkController@getMap');
Route::get('distance', 'WorkController@getDistance');




//ПРОФИЛИ ПОЛЬЗОВАТЕЛЕЙ
Route::get('user',['as' => 'user.profile', 'uses' => 'UserController@index']);
Route::get('user/{id}/show',['as' => 'user.show', 'uses' => 'UserController@show']);
Route::get('user/list',['as' => 'user.list', 'uses' => 'UserController@getList']);
Route::get('user/create',['as' => 'user.create', 'uses' => 'UserController@create']);
Route::get('user/{id}/edit',['as' => 'user.edit', 'uses' => 'UserController@edit']);

Route::post('user/store',['as' => 'user.store', 'uses' => 'UserController@store']);
Route::post('user/{id}/update',['as' => 'user.update', 'uses' => 'UserController@update']);
Route::post('user/{id}/destroy',['as' => 'user.destroy', 'uses' => 'UserController@destroy']);
Route::post('user/{id}/activate',['as' => 'user.activate', 'uses' => 'UserController@activate']);
Route::post('user/{id}/deactivate',['as' => 'user.deactivate', 'uses' => 'UserController@deactivate']);

Route::post('phone/store',['as' => 'phone.store', 'uses' => 'UserController@phoneStore']);
Route::post('phone/{id}/update',['as' => 'phone.update', 'uses' => 'UserController@phoneUpdate']);
Route::post('phone/{id}/destroy',['as' => 'phone.destroy', 'uses' => 'UserController@phoneDestroy']);

Route::post('user/{id}/truck/store',['as' => 'user.truck.store', 'uses' => 'UserController@truckStore']);
Route::post('user/{id}/truck/destroy',['as' => 'user.truck.destroy', 'uses' => 'UserController@truckDestroy']);

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
