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

#Route::get('/', array('https','WelcomeController@index'));

Route::get('/', 'WelcomeController@index');
    
Route::get('/home', 'HomeController@index');

Route::get('distancecalc', 'HomeController@distancecalc');
Route::get('findtruck', 'HomeController@findtruck');

Route::controllers([
	'auth'      => 'Auth\AuthController',
	'password'  => 'Auth\PasswordController',
]);

Route::get('oauth/google', 'OAuthController@google');
Route::get('oauth/facebook', 'OAuthController@facebook');