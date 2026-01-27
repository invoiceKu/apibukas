<?php

use App\Http\Controllers\AlamatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DataStokController;
use App\Http\Controllers\ActivityLogController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Staff routes
Route::prefix('staff')->group(function () {
    require __DIR__.'/staff.php';
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/billing/trial', [BillingController::class, 'trial']);
    // Company routes
    Route::prefix('company')->group(function () {
        Route::post('/create', [CompanyController::class, 'create_company']);
        Route::put('/update', [CompanyController::class, 'update_company']);
        Route::get('/company', [CompanyController::class, 'get_company']);
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::post('/kategori', [KategoriController::class, 'store']);
    Route::get('/kategori/{id}', [KategoriController::class, 'show']);
    Route::put('/kategori/{id}', [KategoriController::class, 'update']);
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::post('/pelanggan', [PelangganController::class, 'store']);
    Route::get('/pelanggan/{id}', [PelangganController::class, 'show']);
    Route::put('/pelanggan/{id}', [PelangganController::class, 'update']);
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/data-stok/user', [DataStokController::class, 'getAllStokByUser']);
    Route::post('/data-stok/tambah', [DataStokController::class, 'tambahStok']);
    Route::post('/data-stok/kurangi', [DataStokController::class, 'kurangiStok']);
});

// Activity Log routes
Route::middleware('auth:sanctum')->prefix('activity-logs')->group(function () {
    Route::get('/', [ActivityLogController::class, 'getActivityLogs']);
    Route::get('/summary', [ActivityLogController::class, 'getActivitySummary']);
    Route::get('/recent', [ActivityLogController::class, 'getRecentActivities']);
});

