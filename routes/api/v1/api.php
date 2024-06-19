<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'Api\V1', 'middleware'=>['api']], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
    
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('logout', 'AuthController@logout');
            Route::get('verificar-token', 'AuthController@verifyToken');
        });
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('index', 'UserController@index');
        Route::get('/{email}', [UserController::class, 'show']);
        Route::put('/{id}', 'UserController@update');
    });

    Route::group(['prefix' => 'packages'], function () {
        Route::get('/', 'TourPackageController@get_all_package');

        Route::group(['prefix' => 'tour'], function () {
            Route::get('/{id}', 'TourController@get_all_tours_by_package');
        });
    });
});