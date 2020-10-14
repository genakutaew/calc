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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        // Refresh the JWT Token
        Route::get('refresh', 'AuthController@refresh');
        // Login User
        Route::post('login', 'AuthController@login');
        // Create New User
        Route::post('create', 'AuthController@create');

        Route::post('update', 'AuthController@update');

        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user', 'AuthController@user');
            // Logout user from application
            Route::post('logout', 'AuthController@logout');
        });
    });

    Route::middleware('auth:api')->group(function () {

        Route::get('getusers', 'ApiController@getusers');

        Route::get('getcalcs', 'ApiController@getcalcs');

        Route::get('getcalc/{id}', 'ApiController@getcalc');

        Route::get('removecalc/{id}', 'ApiController@removecalc');

        Route::post('savecalc', 'ApiController@savecalc');
        Route::post('editcalc', 'ApiController@editcalc');

        Route::get('removeuser/{id}', 'ApiController@removeuser');
    });
});
