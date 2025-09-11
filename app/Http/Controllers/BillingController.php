<?php

namespace App\Http\Controllers;

use App\Models\Billings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    // Fungsi trial
    public function trial(Request $request)
    {
        $user = $request->user();

        // cek apakah user sudah pernah trial
        if ($user->type_account == 0 &&  $user->expired_user == NULL) {
            // Set expired_user 30 hari kedepan jam 23:59:59
            $expired = now()->addDays(30)->setTime(23, 59, 59);

            // Update user ke trial
            $user->update([
                'expired_user' => $expired,
                'type_account' => 1, // trial
            ]);

            // Buat data billing
            $billing = Billings::create([
                'id_users'      => $user->id,
                'waktu_awal'    => now(),
                'waktu_akhir'   => $expired,
                'storage_size'  => $user->storage_size,
                'total_staff'   => 0,
                'pro'           => 1, // trial
                'jumlah_bulan'  => 0,
                'total'         => 0,
                'tipe'          => 0, // trial
                'status'        => 2, // sukses
                'detail'        => 'Trial 30 hari',
                'invoice'       => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            return response()->json([
                'message' => 'Trial berhasil diaktifkan',
                'billing' => $billing,
                'user'    => $user,
            ], 201);
        }

        else {
            return response()->json([
                'message' => 'User sudah pernah trial',
            ], 400);
        }

        
    }
}
