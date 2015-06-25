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
Route::get('distance', 'WelcomeController@distance');


//ДЛЯ ПОЛЬЗОВАТЕЛЕЙ
Route::get('home', 'HomeController@index');
Route::get('map', 'HomeController@map');


//ДЛЯ МОБИЛЬНОГО ПРИЛОЖЕНИЯ И AJAX-ЗАПРОСОВ
Route::post('home', 'JsonController@index');
Route::post('profile','JsonController@index');
Route::post('findtruck','JsonController@inRadius');


//АВТОРИЗАЦИЯ
Route::controllers([
	'auth'      => 'Auth\AuthController',
	'password'  => 'Auth\PasswordController',
]);

//TESTING
#Route::get('/getuser', 'WelcomeController@getuser');
#Route::get('/', array('https','WelcomeController@index'));
