<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class Kernel extends ConsoleKernel
{
    

    // protected function schedule(Schedule $schedule): void
    // {
    //     Log::info("Schedule method dipanggil!");
    //     $schedule->command('users:check-expired')->everyMinute();
    // }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');// Load perintah dari folder Commands

        require base_path('routes/console.php');// Load perintah dari routes/console.php
    }
}