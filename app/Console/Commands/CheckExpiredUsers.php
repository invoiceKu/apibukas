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
            ->where('paket_1', '!=', 0)      // bukan akun gratis
            ->where('paket_2', '!=', 0)
            ->where('paket_3', '!=', 0)
            ->get();

        if ($expiredUsers->isEmpty()) {
            $this->info('Tidak ada user expired.');// tampil di console
            Log::info('Tidak ada user expired.');
            return;
        }

        // Tampilkan daftar email user yang expired
        $this->info("\n=== DAFTAR USER EXPIRED ===");
        $this->info("Total: " . $expiredUsers->count() . " user\n");
        
        $emailList = [];
        foreach ($expiredUsers as $index => $user) {
            $emailList[] = [
                'No' => $index + 1,
                'Email' => $user->email,
                'Expired Date' => $user->expiredUsers->format('Y-m-d H:i:s'),
                'Paket 1' => $user->paket_1,
                'Paket 2' => $user->paket_2,
                'Paket 3' => $user->paket_3
            ];
            
            $msg = "User expired: {$user->email} (Expired: {$user->expiredUsers})";
            $this->warn($msg);
            Log::info($msg);
        }

        // Tampilkan dalam format table
        $this->table(
            ['No', 'Email', 'Expired Date', 'Paket 1', 'Paket 2', 'Paket 3'],
            $emailList
        );


        // Reset akun expired
        foreach ($expiredUsers as $user) {
           $user->update([
                'paket_1' => 0,
                'paket_2' => 0,
                'paket_3' => 0,
        ]);
            $msg = "User expired: {$user->email}";
            $this->warn($msg);   // tampil di console
            Log::info($msg);     // simpan di log
        }

        // $this->info('Total user expired: ' . $expiredUsers->count());
        // Log::info('Total user expired: ' . $expiredUsers->count());
    }
}
