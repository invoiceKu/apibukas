<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('users:check-expired')
    ->everyMinute()// testing
    // ->dailyAt('00:00.00') // Jalankan setiap hari pada tengah malam
    ->description('reset type akun yang sudah expired');// Deskripsi
    // ->runInBackground(false);

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
