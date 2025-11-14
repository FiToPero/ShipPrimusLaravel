<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RateController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-token', [UserController::class, 'getToken']);
Route::get('/refresh-token', [UserController::class, 'refreshToken']);

Route::get('/get-rates', [RateController::class, 'getRates']);

Route::get('/get-rates-minimum', [RateController::class, 'getRatesMinimum']);