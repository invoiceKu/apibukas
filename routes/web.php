<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PricingController;

Route::get('/', [PricingController::class, 'index']);

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/pricing', [PricingController::class, 'index']);