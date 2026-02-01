<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PricingController;

Route::get('/', [PricingController::class, 'index']);

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/migrate-db', function () {
    \Artisan::call('migrate', ["--force" => true]);
    return 'Migrasi Berhasil! Cek database Anda.';
});
Route::get('/pricing', [PricingController::class, 'index']);