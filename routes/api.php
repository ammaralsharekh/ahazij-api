<?php

use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group([ 'middleware' => 'AuthApi'], function () {
    //team
    Route::get('team', 'Api\TeamController@index');
    Route::get('my_team', 'Api\TeamController@my_team');
    Route::post('register_to_team', 'Api\TeamController@register_to_team');

    //game
    Route::get('game', 'Api\GameController@index');
});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('register', 'Api\AuthController@register');
    Route::post('verify_code', 'Api\AuthController@verify_code');
    Route::post('login', 'Api\AuthController@login');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'Api\AuthController@logout');
    });
});

Route::group([ 'middleware' => 'AuthApi'], function () {
    Route::post('chat', 'Api\ChatController@store');
    Route::get('chat/{room_id}/{chat_id?}/{is_up?}', 'Api\ChatController@timeline');
});
