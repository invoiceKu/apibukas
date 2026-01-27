<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\Service\Attribute\Required;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
       
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string|max:15',
            'versi' => 'required',
            'company_name' => 'required|string|max:30',
            'sub_business' => 'nullable|string',
        ]);

       
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'type_user' => 0,
            'paket_1' => 0,
            'paket_2' => 0,
            'paket_3' => 0,
            'foto_profil' => '',
            'versi' => $request->versi,
            'saldo' => 0,
            'saldo_referral' => 0,
            'storage_size' => 500,
            'desktop_plugin' => 0,
            'status_hp' => 0,
            'device_name' => '',
            'device_type' => '',
            'os_version' => '',
            'nomor_struk' => 1,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->api_token = $token;
        $user->save();

        // Buat company baru
        $company = Company::create([
            'id_users' => $user->id,
            'company_name' => $request->company_name,
            'company_owners' => $request->username,
            'company_telp' => $request->no_hp,
            'sub_business' => $request->sub_business,
            'stok_mode' => 'fifo',
            'staff' => 0,
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user->only([
                'id', 'username', 'email', 'created_at', 'expired_user', 'api_token',
                'expired_token', 'paket_1', 'paket1_at', 'paket_2', 'paket2_at', 'paket_3',
                'paket3_at', 'foto_profil', 'saldo', 'storage_size','desktop_plugin',
                'status_hp', 'delete_at'
            ]),
            'company' => $company,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'versi' => 'required',
        ]);
        
        // Load user dengan relasi company
        $user = User::with('company')->where('email', $request->email)->first();
        
        // Cek apakah email terdaftar
        if (!$user) {
            return response()->json(['message' => 'Email belum terdaftar.'], 404);
        }
        
        // Cek apakah password benar
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }
        
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->api_token = $token;
        $user->versi = $request->versi;
        $user->save();
        
        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user->only([
                'id', 'username', 'email', 'created_at', 'expired_user', 'api_token',
                'expired_token', 'paket_1', 'paket1_at', 'paket_2', 'paket2_at', 'paket_3',
                'paket3_at', 'foto_profil', 'saldo', 'storage_size','desktop_plugin',
                'status_hp', 'delete_at'
            ]),
            'company' => $user->company ? $user->company : null,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ], 200);
    }

    public function dataUser()
    {
        $data = User::all();
        return view('data-User', ['data' => $data]);
    }

    function showUser()
    {
        return view('User');
    }
}
