<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RateController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/get-token', [UserController::class, 'getToken']);

Route::post('/refresh-token', [UserController::class, 'refreshToken']);

Route::post('/get-rates', [RateController::class, 'getRates']);

Route::post('/get-rates-minimum', [RateController::class, 'getRatesMinimum']);