<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Create a new company
     */
    public function create_company(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:30',
            'company_address' => 'required|string|max:80',
            'company_owners' => 'required|string|max:30',
            'company_telp' => 'required|string|max:15',
            'motto' => 'nullable|string|max:125',
            'pajak_default' => 'nullable|numeric',
            'sub_business' => 'nullable|string',
            'currency' => 'nullable|string',
            'currency_code' => 'nullable|string',
            'currency_country' => 'nullable|string',
            'stok_mode' => 'nullable|string',
            'negara' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kota' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah user sudah memiliki company
        $existingCompany = Company::where('id_users', $request->user()->id)->first();
        if ($existingCompany) {
            return response()->json([
                'message' => 'User already has a company',
                'data' => $existingCompany
            ], 409);
        }

        // Parse location_store_point dari latitude dan longitude
        if ($request->has('latitude') && $request->has('longitude')) {
            $latitude = $request->latitude;
            $longitude = $request->longitude;
        }

        // Buat company baru
        $company = Company::create([
            'id_users' => $request->user()->id,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_owners' => $request->company_owners,
            'company_telp' => $request->company_telp,
            'motto' => $request->motto,
            'pajak_default' => $request->pajak_default ?? 0,
            'sub_business' => $request->sub_business,
            'currency' => $request->currency,
            'currency_code' => $request->currency_code,
            'currency_country' => $request->currency_country,
            'stok_mode' => $request->stok_mode,
            'negara' => $request->negara,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            // 'location_store_point' => $location,
            'latitude' => $request -> $latitude,
            'longitude' => $request -> $longitude,

        ]);

        return response()->json([
            'message' => 'Company created successfully',
            'data' => $company
        ], 201);
    }

    /**
     * Update an existing company
     */
    public function update_company(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'company_name' => 'sometimes|string|max:30',
            'company_address' => 'sometimes|string|max:80',
            'company_owners' => 'sometimes|string|max:30',
            'company_telp' => 'sometimes|string|max:15',
            'motto' => 'nullable|string|max:125',
            'pajak_default' => 'nullable|numeric',
            'sub_business' => 'nullable|string',
            'currency' => 'nullable|string',
            'currency_code' => 'nullable|string',
            'currency_country' => 'nullable|string',
            'stok_mode' => 'nullable|string',
            'negara' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kota' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    // Cari company berdasarkan user ID dari token
    $company = Company::where('id_users', $request->user()->id)->first();

    if (!$company) {
        return response()->json([
            'message' => 'Company not found'
        ], 404);
    }

    // Parse location_store_point dari latitude dan longitude jika ada
    if ($request->has('latitude') && $request->has('longitude')) {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $company->location_store_point = DB::raw("ST_GeomFromText('POINT($latitude $longitude)')");
        $company->save();
    }

    // Update field yang ada di request
    $updateData = $request->only([
        'company_name', 'company_address', 'company_owners', 'company_telp',
        'motto', 'pajak_default', 'sub_business', 'currency', 'currency_code',
        'currency_country', 'stok_mode', 'negara', 'provinsi', 'kota'
    ]);

    // Hapus field yang null dari updateData
    $updateData = array_filter($updateData, function($value) {
        return !is_null($value);
    });

    // Lakukan update
    $company->update($updateData);

    return response()->json([
        'message' => 'Company updated successfully',
        'data' => $company
    ], 200);
    }

    /**
     * Get user's company
     */
    public function get_company(Request $request)
    {
        $company = Company::where('id_users', $request->user()->id)->first();

        if (!$company) {
            return response()->json([
                'message' => 'Company not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Company retrieved successfully',
            'data' => $company
        ], 200);
    }
}