<?php

use App\Http\Controllers\AlamatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CompanyController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Company routes
    Route::prefix('company')->group(function () {
        Route::post('/create', [CompanyController::class, 'create_company']);
        Route::put('/update', [CompanyController::class, 'update_company']);
        Route::get('/', [CompanyController::class, 'get_company']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });
    
    Route::get('/test', function () {
        return response()->json(['message' => 'API is working correctly']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/barang', [BarangController::class, 'index']);
    Route::post('/barang', [BarangController::class, 'store']);
    Route::get('/barang/{id}', [BarangController::class, 'show']);
    Route::put('/barang/{id}', [BarangController::class, 'update']);
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']);
});
