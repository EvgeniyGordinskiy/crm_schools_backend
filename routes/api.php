<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function(){
    Route::post('', ['as' => '', 'uses' => 'Auth\AuthController@authenticate']);
    Route::post('register', ['as' => 'register', 'uses' => 'Auth\AuthController@register']);
    Route::post('reset_password', ['as' => 'resetPassword', 'uses' => 'Auth\AuthController@resetPassword']);
    Route::get('change_password/{token}', ['as' => 'changePassword', 'uses' => 'Auth\AuthController@changePassword']);
    Route::get('refresh_token', ['as' => 'auth.refresh', 'uses' => 'Auth\AuthController@refresh']);
});

Route::group([
    'middleware' => ['jwt.auth'],
    'prefix' => 'account'
], function(){
    Route::get('', ['as' => 'account', 'uses' => 'AccountController@index']);
});