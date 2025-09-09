<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    
    public function register(Request $request)
    {
       
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string|max:15',
        ]);

       
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Gunakan Hash::make()
            'no_hp' => $request->no_hp,
            'type_account' => 0,
            'type_user' => 0,
            'foto_profil' => '',
            // 'versi' => env('VERSI_APP'),
            'versi' => '1.0.0',
            'saldo' => 0,
            'saldo_referral' => 0,
            'storage_size' => 500,
            'desktop_plugin' => 0,
            'status_hp' => 0,
            'device_name' => '',
            'device_type' => '',
            'os_version' => '',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->api_token = $token;
        $user->save();

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user->only([
                'username', 'email', 'created_at', 'expired_user', 'api_token', 
                'expired_token', 'type_account', 'foto_profil', 'saldo', 'storage_size','desktop_plugin', 
                'status_hp', 'delete_at'
            ]),
        ], 201);
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    // Load user dengan relasi company
    $user = User::with('company')->where('email', $request->email)->first();
    
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Email atau password salah.'], 401);
    }
    
    $user->tokens()->delete();
    $token = $user->createToken('auth_token')->plainTextToken;
    $user->api_token = $token;
    $user->save();
    
    return response()->json([
        'message' => 'Login berhasil',
        'user' => $user->only([
            'id', 'username', 'email', 'created_at', 'expired_user', 'api_token', 
            'expired_token', 'type_account', 'foto_profil', 'saldo', 'storage_size','desktop_plugin','desktop_at', 
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
