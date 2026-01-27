<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StaffController;

Route::post('/create', [StaffController::class, 'create']);
Route::post('/login', [StaffController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [StaffController::class, 'logout']);
});