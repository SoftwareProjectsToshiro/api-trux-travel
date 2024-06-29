<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api\V2', 'middleware'=>['api']], function () {
    Route::get('testing', 'TestingController@index');
});
