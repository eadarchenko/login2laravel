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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/', 'HomeController@index')->name('home.index');

Route::group(['middleware' => ['guest']], function() {

    Route::post('/register', 'RegisterController@register')->name('register.perform');

    Route::post('/login', 'LoginController@login')->name('login.perform');

});

Route::group(['middleware' => ['auth']], function() {

    Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
});
































/*Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


Route::post('/login',[passportAuthController::class,'authenticate']);
Route::post('/register',[passportAuthController::class,'register']);
//agregue este middleware para asegurarse de que cada solicitud sea autenticada
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/logout',[passportAuthController::class,'logout']);
    Route::get('/date', [passportAuthController::class,'getDetail']);
});*/
