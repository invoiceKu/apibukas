<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Billings;
use Illuminate\Support\Facades\Log;

class CheckTrial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-trial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset trial paket';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Command users:check-expired dijalankan pada: " . now());

        // Cari user yang sudah expired
        $expiredUsers = User::whereNotNull('expired_user')
            ->where('paket1_at', '<', now())   // sudah lewat
            ->where('paket_1', '==', 1)      // trial == 1
            ->where('paket2_at', '<', now())
            ->where('paket_2', '==', 1)
            ->where('paket3_at', '<', now())
            ->where('paket_3', '==', 1)
            ->get();

        if ($expiredUsers->isEmpty()) {
            $this->info('Tidak ada user trial expired.');// tampil di console
            Log::info('Tidak ada user trial expired.');
            return;
        }

        // Reset akun expired
        foreach ($expiredUsers as $user) {
            $user->update([
                'paket_1' => 0,
                'paket_2' => 0,
                'paket_3' => 0,
        ]);
// id user tidak
            $msg = "User expired: {$user->email}";
            $this->warn($msg);   // tampil di console
            Log::info($msg);     // simpan di log
        }

        $this->info('Total user expired: ' . $expiredUsers->count());
        Log::info('Total user expired: ' . $expiredUsers->count());
    }
}
