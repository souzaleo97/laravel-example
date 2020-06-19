<?php

use Illuminate\Support\Facades\Route;

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

// Welcome
Route::get('/', 'WelcomeController@index');

Route::get(
    'login/facebook',
    'Auth\SocialAuthFacebookController@redirectToProvider'
);
Route::get(
    'login/facebook/callback',
    'Auth\SocialAuthFacebookController@handleProviderCallback'
);

Route::post('/users', 'UserController@store');
Route::post('/login', 'Auth\LoginController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', 'Auth\LoginController@logout');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index');
        Route::get('{id}', 'UserController@show');
        Route::put('{id}', 'UserController@update');
        Route::delete('{id}', 'UserController@delete');
    });

    Route::group(['prefix' => 'notes'], function () {
        Route::get('/', 'NoteController@index');
        Route::get('{id}', 'NoteController@show');
        Route::post('/', 'NoteController@store');
        Route::put('{id}', 'NoteController@update');
        Route::delete('{id}', 'NoteController@delete');
    });
});
