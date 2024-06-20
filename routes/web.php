<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NiubizPaymentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'payment-mobile'], function () {
    Route::get('/', [PaymentController::class, 'payment'])->name('payment-mobile');
});

Route::get('payment-success', [PaymentController::class, 'success'])->name('payment-success');
Route::get('payment-fail', [PaymentController::class, 'fail'])->name('payment-fail');

/*Niubiz*/
Route::post('niubiz-success/{order_id}/{_token}', [NiubizPaymentController::class, 'success'])->name('niubiz-success');
Route::get('niubiz/{order_id}', [NiubizPaymentController::class, 'viewNiubiz'])->name('view-niubiz');
