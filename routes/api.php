<?php

use App\Http\Middleware\VerifyJWTToken;
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

/**
 *  Routes for Authentication
 */
Route::group([
    'prefix' => 'auth',
    'as' => 'auth'
], function(){
    Route::post('', ['as' => '', 'uses' => 'Auth\AuthController@authenticate']);
    Route::post('register', ['as' => 'register', 'uses' => 'Auth\AuthController@register']);
    Route::post('reset_password', ['as' => 'resetPassword', 'uses' => 'Auth\AuthController@resetPassword']);
    Route::get('change_password/{token}', ['as' => 'changePassword', 'uses' => 'Auth\AuthController@changePassword']);
    Route::get('refresh_token', ['as' => 'refresh', 'uses' => 'Auth\AuthController@refresh']);
});


/**
 *
 * Routes for social auth.
 *
 */
Route::group([
    'prefix' => 'social',
    'as' => 'social'
], function(){
    Route::post('{provider}', 'Auth\AuthSocialController@authenticate');
});

/**
 *
 * Routes for password changing
 *
 */
Route::group([
    'as' => 'password.',
    'prefix' => 'password',
], function(){
    Route::post('reset', ['as' => 'reset', 'uses' => 'Auth\AuthController@resetPassword'])->middleware(VerifyJWTToken::class);
    Route::get('checkResetToken', ['as' => 'change', 'uses' => 'Auth\AuthController@check_reset_token']);
    Route::post('change', ['as' => 'change', 'uses' => 'Auth\AuthController@changePassword']);
    Route::post('checkToken', ['as' => 'change', 'uses' => 'Auth\AuthController@check_reset_token']);
});

/**
 *
 * Routes for verifying
 *
 */
Route::group([
    'as' => 'verify.',
    'prefix' => 'verify',
], function(){
    Route::post('email', ['as' => 'change', 'uses' => 'VerifyController@verifyEmail']);
    Route::post('sms', ['as' => 'change', 'uses' => 'VerifyController@verifyPhone']);
});

/**
 *  Authenticated routes
 */
Route::group([
    'middleware' => ['jwt_auth'],
], function(){
    
    /**
     *  Routes for users account
     */
    Route::group([
        'prefix' => 'account',
        'as' => 'account'
    ], function() {
        Route::get('', ['as' => 'index', 'uses' => 'AccountController@index']);
    });
    
    /**
     *
     *  Routes for permissions
     *
     */
    Route::group([
        'prefix' => 'permissions',
        'as' => 'permissions'
    ], function(){
        Route::get('', ['as' => 'index', 'uses' => 'PermissionController@index']);
        Route::get('roles', ['as' => 'roles.index', 'uses' => 'PermissionController@roles_permissions']);
        Route::post('', ['as' => 'update', 'uses' => 'PermissionController@update']);
    });

    /**
     *
     *  Routes for oles
     *
     */
    Route::group([
        'prefix' => 'roles',
        'as' => 'role'
    ], function(){
        Route::get('', ['as' => 'index', 'uses' => 'RoleController@index']);
    });

    /**
     *
     * Routes for payment
     *
     */
    Route::group([
        'as' => 'payment.',
        'prefix' => 'payment',
    ], function(){
        Route::post('', ['as' => 'storeSettings', 'uses' => 'PaymentController@storeSettings']);
    });

    /**
     * 
     *  Routes for programs
     * 
     */
    Route::group([
        'prefix' => 'program',
        'as' => 'program'
    ], function(){
        Route::post('', ['as' => 'create', 'uses' => 'ProgramController@create']);
    });
    
    /**
     * 
     *  Routes for school
     * 
     */
    Route::group([
        'prefix' => 'school',
        'as' => 'school'
    ], function(){
        Route::post('', ['as' => 'create', 'uses' => 'SchoolController@create']);
    });
});
