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
// ДЛЯ ГОСТЕЙ
Route::get('/', 'WelcomeController@index');



// ДЛЯ ПОЛЬЗОВАТЕЛЕЙ
Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);

// ДЛЯ АКТИВИРОВАННЫХ АККАУНТОВ ПОЛЬЗОВАТЕЛЕЙ

Route::get('map', ['as' => 'work.map', 'uses' => 'WorkController@getMap']);
Route::get('distance', ['as' => 'work.distance', 'uses' => 'WorkController@getDistance']);


// ПРОФИЛИ ПОЛЬЗОВАТЕЛЕЙ
Route::get('user',['as' => 'user.profile', 'uses' => 'UserController@index']);
Route::get('user/list',['as' => 'user.list', 'uses' => 'UserController@getList']);
Route::get('user/trash',['as' => 'user.trash', 'uses' => 'UserController@getTrash']);
Route::get('user/create',['as' => 'user.create', 'uses' => 'UserController@create']);
Route::get('user/{id}/show',['as' => 'user.show', 'uses' => 'UserController@show']);
Route::get('user/{id}/edit',['as' => 'user.edit', 'uses' => 'UserController@edit']);

Route::post('user/store',['as' => 'user.store', 'uses' => 'UserController@store']);
Route::post('user/{id}/restore',['as' => 'user.restore', 'uses' => 'UserController@restore']);
Route::post('user/{id}/update',['as' => 'user.update', 'uses' => 'UserController@update']);
Route::post('user/{id}/destroy',['as' => 'user.destroy', 'uses' => 'UserController@destroy']);

Route::post('phone/store',['as' => 'phone.store', 'uses' => 'UserController@phoneStore']);
Route::post('phone/{id}/update',['as' => 'phone.update', 'uses' => 'UserController@phoneUpdate']);
Route::post('phone/{id}/destroy',['as' => 'phone.destroy', 'uses' => 'UserController@phoneDestroy']);

Route::post('user/{id}/files/store',['as' => 'user.files.store', 'uses' => 'UserController@filesStore']);
Route::post('user/{id}/file/store',['as' => 'user.file.store', 'uses' => 'UserController@fileStore']);


// ГРУЗОВИКИ
Route::any('truck/list',['as' => 'truck.list', 'uses' => 'TruckController@index']);
Route::get('truck/{id}',['as' => 'truck.show', 'uses' => 'TruckController@show']);
Route::get('truck/{id}/create',['as' => 'truck.create', 'uses' => 'TruckController@create']);
Route::get('truck/{id}/edit',['as' => 'truck.edit', 'uses' => 'TruckController@edit']);

Route::post('truck/{id}/store',['as' => 'truck.store', 'uses' => 'TruckController@store']);
Route::post('truck/{id}/update',['as' => 'truck.update', 'uses' => 'TruckController@update']);
Route::post('truck/{id}/destroy',['as' => 'truck.destroy', 'uses' => 'TruckController@destroy']);

Route::post('truck/{id}/files/store',['as' => 'truck.files.store', 'uses' => 'TruckController@filesStore']);
Route::post('truck/{id}/file/store',['as' => 'truck.file.store', 'uses' => 'TruckController@fileStore']);

// ОРГАНИЗАЦИИ
Route::get('legal/{id}',['as' => 'legal.show', 'uses' => 'LegalController@show']);
Route::get('legal/{id}/create',['as' => 'legal.create', 'uses' => 'LegalController@create']);
Route::get('legal/{id}/edit',['as' => 'legal.edit', 'uses' => 'LegalController@edit']);

Route::post('legal/{id}/store',['as' => 'legal.store', 'uses' => 'LegalController@store']);
Route::post('legal/{id}/update',['as' => 'legal.update', 'uses' => 'LegalController@update']);
Route::post('legal/{id}/destroy',['as' => 'legal.destroy', 'uses' => 'LegalController@destroy']);

Route::post('legal/{id}/files/store',['as' => 'legal.files.store', 'uses' => 'LegalController@filesStore']);

// ФАЙЛЫ
Route::get('file/{id}',['as' => 'file.show', 'uses' => 'FileController@show']);

Route::post('file/{id}/destroy',['as' => 'file.destroy', 'uses' => 'FileController@destroy']);

// ДЛЯ МОБИЛЬНОГО ПРИЛОЖЕНИЯ И AJAX-ЗАПРОСОВ
Route::any('json/profile',['as' => 'json.profile', 'uses' => 'JsonController@index']);
Route::post('json/findtruck',['as' => 'json.find.trucks', 'uses' => 'JsonController@inRadius']);
Route::post('json/legal',['as' => 'json.legal', 'uses' => 'JsonController@autocompleteLegals']);


// АВТОРИЗАЦИЯ
Route::controllers([
	'auth'      => 'Auth\AuthController',
	'password'  => 'Auth\PasswordController',
]);

// TESTING
#Route::get('/getuser', 'WelcomeController@getuser');
#Route::get('/', array('https','WelcomeController@index'));
