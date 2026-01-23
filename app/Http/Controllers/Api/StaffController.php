<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Create a new staff member
     */
    public function create(Request $request)
    {
        // Validate required fields
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'foto_profil' => 'nullable|string',
            'nomor_struk' => 'nullable|integer',
            'versi' => 'nullable|string',
            'device_name' => 'nullable|string',
            'device_type' => 'nullable|string',
            'os_version' => 'nullable|string',
            'api_token' => 'nullable|string',
        ]);

        // Check if email already exists in users or staff tables
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'Email already exists in users table'
            ], 400);
        }

        if (Staff::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'Email already exists in staff table'
            ], 400);
        }

        // Get the authenticated user's id
        $userId = Auth::id();

        // Create staff member
        $staff = Staff::create([
            'id_users' => $userId,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'foto_profil' => $request->foto_profil,
            'nomor_struk' => $request->nomor_struk,
            'versi' => $request->versi ?? '',
            'device_name' => $request->device_name ?? '',
            'device_type' => $request->device_type ?? '',
            'os_version' => $request->os_version ?? '',
            'api_token' => $request->api_token,
        ]);

        return response()->json([
            'message' => 'Staff created successfully',
            'staff' => $staff
        ], 201);
    }

    /**
     * Staff login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'versi' => 'required',
        ]);

        // Find staff by email
        $staff = Staff::where('email', $request->email)->first();

        // Check if staff exists and password is correct
        if (!$staff || !Hash::check($request->password, $staff->password)) {
            return response()->json([
                'message' => 'Email or password is incorrect'
            ], 401);
        }

        // Update staff version
        $staff->versi = $request->versi;
        $staff->save();

        // Create token for staff
        $token = $staff->createToken('staff_auth_token')->plainTextToken;
        $staff->api_token = $token;
        $staff->save();

        return response()->json([
            'message' => 'Staff login successful',
            'staff' => $staff,
            'token' => $token
        ], 200);
    }

    /**
     * Staff logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Staff logout successful'
        ], 200);
    }
}