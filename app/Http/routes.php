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
Route::get('distance', ['as' => 'home.distance', 'uses' => 'HomeController@getDistance']);

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
Route::get('truck/radius', ['as' => 'truck.radius', 'uses' => 'TruckController@truckInRadius']);
Route::get('truck/bounds', ['as' => 'truck.bounds', 'uses' => 'TruckController@truckInBounds']);
Route::any('truck/list',['as' => 'truck.list', 'uses' => 'TruckController@index']);
Route::get('truck/{id}/show',['as' => 'truck.show', 'uses' => 'TruckController@show']);
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

// ОТСЛЕЖИВАНИЕ
Route:: get('tracking',['as' => 'tracking', 'uses' => 'TrackingController@index']);
Route:: post('tracking/store',['as' => 'tracking.store', 'uses' => 'TrackingController@store']);
Route:: post('tracking/{id}/destroy',['as' => 'tracking.destroy', 'uses' => 'TrackingController@destroy']);
Route:: get('tracking/{id}/ajax_form',['as' => 'tracking.ajax.form', 'uses' => 'TrackingController@show']);

// ПЕРЕДАЧА КООРДИНАТ
Route:: post('track/{lat}/{lng}/store',['as' => 'track.latlng.store', 'uses' => 'JsonController@trackLatLngStore']);
Route:: post('track/store',['as' => 'track.store', 'uses' => 'TrackController@store']);

// ПЕРЕДАЧА SMS
Route:: get('sms/token/{id}',['as' => 'sms.token', 'uses' => 'UserController@smsToken']);
Route:: post('sms/token/{id}/send',['as' => 'sms.token.send', 'uses' => 'JsonController@sendSmsToken']);
Route:: post('sms/token/{id}/confirm',['as' => 'sms.token.confirm', 'uses' => 'UserController@confirmSmsToken']);
Route:: post('sms/token/{id}/verify',['as' => 'sms.token.verify', 'uses' => 'JsonController@smsTokenVerify']);

// ДЛЯ МОБИЛЬНОГО ПРИЛОЖЕНИЯ И AJAX-ЗАПРОСОВ
Route::any('json/profile',['as' => 'json.profile', 'uses' => 'JsonController@index']);
Route::post('json/trucks/radius',['as' => 'json.trucks.radius', 'uses' => 'JsonController@inRadius']);
Route::post('json/trucks/bounds',['as' => 'json.trucks.bounds', 'uses' => 'JsonController@inVisibleRegion']);
Route::post('json/{id}/truck',['as' => 'json.truck.get', 'uses' => 'JsonController@getTruckJson']);
Route::post('json/legal',['as' => 'json.legal', 'uses' => 'JsonController@autocompleteLegals']);
Route::post('json/trucks/search',['as' => 'json.trucks.search', 'uses' => 'JsonController@trucks']);
Route::post('json/trucks/query',['as' => 'json.trucks.query', 'uses' => 'JsonController@trucksQuery']);
Route::post('json/truck/types',['as' => 'json.truck.types', 'uses' => 'JsonController@truckTypes']);
Route::post('json/statuses',['as' => 'json.statuses', 'uses' => 'JsonController@statuses']);
Route::post('json/countries',['as' => 'json.countries', 'uses' => 'JsonController@countries']);
Route::post('json/tracking/store',['as' => 'json.tracking.store', 'uses' => 'JsonController@trackingStore']);
Route::post('json/tracking/destroy',['as' => 'json.tracking.destroy', 'uses' => 'JsonController@trackingDestroy']);

// РЭЙТИНГ
Route::get('rating/{id}/create',['as' => 'rating.create', 'uses' => 'RatingController@create']);
Route::post('rating/store',['as' => 'rating.store', 'uses' => 'RatingController@store']);

// АВТОРИЗАЦИЯ
Route::controllers([
	'auth'      => 'Auth\AuthController',
	'password'  => 'Auth\PasswordController',
]);

// TESTING
#Route::get('/getuser', 'WelcomeController@getuser');
#Route::get('/', array('https','WelcomeController@index'));
