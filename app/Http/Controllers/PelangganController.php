<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;


class PelangganController extends Controller
{
    //list pelanggan
    public function index(Request $request)
    {
        $pelanggans = Pelanggan::where('id_users', $request->user()->id)->get();
        return response()->json($pelanggans, 200);
    }

    //simpan pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan'  => 'required|string|max:100',
            'email_pelanggan' => 'required|email|unique:pelanggans,email_pelanggan',
            'no_pelanggan'    => 'nullable|string|max:20',
            'kode_pelanggan'  => 'required|string|max:20|unique:pelanggans,kode_pelanggan',
            'alamat_pelanggan'=> 'nullable|string',
            'foto_pelanggan'  => 'nullable|string',
            'saldo_pelanggan' => 'nullable|numeric',
            'poin_pelanggan'  => 'nullable|integer',
        ]);

        $pelanggan = Pelanggan::create([
            'id_users'        => $request->user()->id,
            'nama_pelanggan'  => $request->nama_pelanggan,
            'email_pelanggan' => $request->email_pelanggan,
            'no_pelanggan'    => $request->no_pelanggan,
            'kode_pelanggan'  => strtoupper($request->kode_pelanggan),
            'alamat_pelanggan'=> $request->alamat_pelanggan,
            'foto_pelanggan'  => $request->foto_pelanggan,
            'saldo_pelanggan' => $request->saldo_pelanggan ?? 0,
            'poin_pelanggan'  => $request->poin_pelanggan ?? 0,
        ]);

        return response()->json([
            'message' => 'Pelanggan berhasil ditambahkan',
            'data' => $pelanggan,
        ], 201);
    }

    //detail pelanggan
    public function show($id, Request $request)
    {
        // $pelanggan = Pelanggan::where('id_users', $request->user()->id)->findOrFail($id);
        // return response()->json($pelanggan, 200);

        $pelanggan = Pelanggan::find($id);

        // jika id tidak ada
        if (!$pelanggan) {
            return response()->json([
                'message' => 'Pelanggan ID tidak ditemukan'
            ], 404);
        }

        // cek token
        if ($pelanggan->id_users !== $request->user()->id) {
            return response()->json([
                'message' => 'Token invalid'
            ], 400);
        }

        return response()->json($pelanggan, 200);
    }

    //update pelanggan
    public function update(Request $request, $id)
    {
        // $pelanggan = Pelanggan::where('id_users', $request->user()->id)->findOrFail($id);

        $pelanggan = Pelanggan::find($id);

        // tidak ada id
        if (!$pelanggan) {
            return response()->json([
                'message' => 'Pelanggan ID tidak ditemukan'
            ], 404);
        }

        // cek token
        if ($pelanggan->id_users !== $request->user()->id) {
            return response()->json([
                'message' => 'Token invalid'
            ], 400);
        }


        $request->validate([
            'email_pelanggan' => 'sometimes|email|unique:pelanggans,email_pelanggan,' . $pelanggan->id,
            'no_pelanggan'    => 'sometimes|string|max:20',
            'kode_pelanggan'  => 'nullable|string|unique:pelanggans,kode_pelanggan,' . $pelanggan->id,
        ]);

        $pelanggan->update(array_merge(
            $request->all(),
            ['kode_pelanggan' => $request->kode_pelanggan ? strtoupper($request->kode_pelanggan) : $pelanggan->kode_pelanggan]
        ));

        return response()->json([
            'message' => 'Pelanggan berhasil diperbarui',
            'data' => $pelanggan,
        ], 200);
    }

    //hapus pelanggan
    public function destroy($id, Request $request)
    {
        // $pelanggan = Pelanggan::where('id_users', $request->user()->id)->findOrFail($id);

        $pelanggan = Pelanggan::find($id);
        
        // jika id tidak ada
        if (!$pelanggan) {
            return response()->json([
                'message' => 'Pelanggan ID tidak ditemukan'
            ], 404);
        }

        // cek token
        if ($pelanggan->id_users !== $request->user()->id) { //harusnya cek ke api_token
            return response()->json([
                'message' => 'Token invalid'
            ], 400);
        }

        $pelanggan->delete();

        return response()->json([
            'message' => 'Pelanggan berhasil dihapus',
        ], 200);
    }
}
