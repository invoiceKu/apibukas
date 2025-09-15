<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CheckExpiredUsers extends Command
{
    // Nama command yg dipakai di artisan
    protected $signature = 'users:check-expired';

    // Deskripsi
    protected $description = 'Reset akun user yang expired menjadi free';

    // Eksekusi command
    public function handle(): void
    {
        $this->info("Command users:check-expired dijalankan pada: " . now());

        // Cari user yang sudah expired
        $expiredUsers = User::whereNotNull('expired_user')
            ->where('expired_user', '<', now())   // sudah lewat
            ->where('type_account', '!=', 0)      // bukan akun gratis
            ->get();

        if ($expiredUsers->isEmpty()) {
            $this->info('Tidak ada user expired.');// tampil di console
            Log::info('Tidak ada user expired.');
            return;
        }

        // Reset akun expired
        foreach ($expiredUsers as $user) {
            $user->update(['type_account' => 0]);
// id user tidak
            $msg = "User expired: {$user->email}";
            $this->warn($msg);   // tampil di console
            Log::info($msg);     // simpan di log
        }

        $this->info('Total user expired: ' . $expiredUsers->count());
        Log::info('Total user expired: ' . $expiredUsers->count());
    }
}
