<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // list semua kategori user login
    public function index(Request $request)
    {
        $kategoris = Kategori::where('id_users', $request->user()->id)->get();
        return response()->json($kategoris, 200);
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        $kategori = Kategori::create([
            'id_users'      => $request->user()->id,
            'nama_kategori' => $request->nama_kategori,
        ]);

        //tambahkan fungsi pengecekan apakah token yang dipakai masih sama dengan id user

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $kategori,
        ], 201);
    }

    //detail kategori
    public function show($id, Request $request)
    {
        // $kategori = Kategori::where('id_users', $request->user()->id)->findOrFail($id);
        // return response()->json($kategori, 200);

        $kategori = Kategori::find($id);

        // jika id tidak ada
        if (!$kategori) {
            return response()->json([
                'message' => 'Kategori ID tidak ditemukan'
            ], 404);
        }

        // cek token
        // if ($resp = $this->validate(['api_token' => 'required|string'], $request->api_token() )) {
        //     return $resp;
        // }
        if ($kategori->id_users !== $request->user()->id) {
            return response()->json([
                'message' => 'Token invalid'
            ], 400);
        }

        return response()->json($kategori, 200);
    }

    // update kategori
    public function update(Request $request, $id)
    {
        // $kategori = Kategori::where('id_users', $request->user()->id)->findOrFail($id);

        $kategori = Kategori::find($id);

        // jika id tidak ada
        if (!$kategori) {
            return response()->json([
                'message' => 'Kategori ID tidak ditemukan'
            ], 404);
        }

        // cek token
        if ($kategori->id_users !== $request->user()->id) {
            return response()->json([
                'message' => 'Token invalid'
            ], 400);
        }


        $request->validate([
            'nama_kategori' => 'sometimes|required|string|max:100',
        ]);

        $kategori->update($request->all());

        return response()->json([
            'message' => 'Kategori berhasil diperbarui',
            'data' => $kategori,
        ], 200);
    }

    //hapus kategori
    public function destroy($id, Request $request)
    {
        // $kategori = Kategori::where('id_users', $request->user()->id)->findOrFail($id);

        $kategori = Kategori::find($id);

        // jika id tidak ada
        if (!$kategori) {
            return response()->json([
                'message' => 'Kategori ID tidak ditemukan'
            ], 404);
        }

        // cek token
        if ($kategori->id_users !== $request->user()->id) {
            return response()->json([
                'message' => 'Token invalid'
            ], 400);
        }

        $kategori->delete();

        return response()->json([
            'message' => 'Kategori berhasil dihapus',
        ], 200);
    }
}
