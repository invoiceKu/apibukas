<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PricingController;

Route::get('/', [PricingController::class, 'index']);

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/migrate-db', function () {
    try {

        \Artisan::call('optimize:clear');
        \Artisan::call('config:clear');
        
        echo "Cache berhasil dibersihkan.<br>";

        $socket = config('database.connections.mysql.unix_socket');
        echo "Target Socket: " . ($socket ? $socket : "KOSONG (Masalah disini!)") . "<br>";

        \DB::connection()->getPdo();
        echo "Tes Koneksi: BERHASIL! <br>";

        \Artisan::call('migrate', ["--force" => true]);
        return '<b>SUKSES! Tabel berhasil dibuat.</b>';
        
    } catch (\Exception $e) {
        return "ERROR: " . $e->getMessage();
    }
});
Route::get('/pricing', [PricingController::class, 'index']);