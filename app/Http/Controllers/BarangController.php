<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\barangs;
use App\Models\data_stok;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    // List semua barang user login
    public function index(Request $request)
    {
        $barangs = barangs::where('id_users', $request->user()->id)->get();
        
        // Tambahkan data stok untuk setiap barang
        $barangsWithStok = $barangs->map(function ($barang) {
            $dataStok = data_stok::where('id_barangs', $barang->id)->get();
            
            $barang->data_stok = $dataStok->map(function ($stok) {
                return [
                    'id' => $stok->id,
                    'id_barangs' => $stok->id_barangs,
                    'stok' => $stok->stok,
                    'harga_dasar' => $stok->harga_dasar,
                    'created_at' => $stok->created_at,
                    'expired_at' => $stok->expired_at,
                    'updated_at' => $stok->updated_at,
                ];
            });
            
            return $barang;
        });
        
        return response()->json($barangsWithStok, 200);
    }

    // Simpan barang baru
    public function store(Request $request)
    {
    $request->validate([
        'foto_barang'   => 'nullable|string',
        'nama_barang'   => 'sometimes|string',
        'kode_barang'   => 'required|string|unique:barangs,kode_barang',
        'tipe_barang'   => 'required|in:default,addon',
        'tipe_stok'     => 'required|boolean',
        'stok'          => 'required|numeric',
        'harga_dasar'   => 'required|numeric',
        'harga_jual'    => 'required|numeric',
        'nama_kategori' => 'nullable|string',
        'tipe_diskon'   => 'required|boolean',
        'nilai_diskon'  => 'required|numeric',
        'berat'         => 'nullable|string',
        'satuan'        => 'nullable|string',
        'tampil_transaksi'  => 'required|boolean',
    ]);

    // Get current user's storage capacity
    $user = $request->user();
    $currentStorageUsage = barangs::where('id_users', $user->id)->count();
    $storageCapacity = $user->storage_size;

    // Check if storage capacity is exceeded
    if ($currentStorageUsage >= $storageCapacity) {
        return response()->json([
            'message' => 'Gagal menambahkan barang. Kapasitas penyimpanan penuh (' . $currentStorageUsage . '/' . $storageCapacity . ')',
            'data' => null,
        ], 400);
    }

    $barang = barangs::create([
        'id_users'      => $user->id, // otomatis dari token Sanctum
        'foto_barang'   => $request->foto_barang ?? '',
        'nama_barang'   => $request->nama_barang,
        'kode_barang'   => strtoupper($request->kode_barang), // uppercase otomatis
        'tipe_barang'   => $request->tipe_barang,
        'tipe_stok'     => $request->tipe_stok,
        'stok'          => ($request->tipe_stok == 1) ? $request->stok : 0,
        'harga_dasar'   => $request->harga_dasar,
        'harga_jual'    => $request->harga_jual,
        'nama_kategori' => $request->nama_kategori ?? '',
        'tipe_diskon'   => $request->tipe_diskon,
        'nilai_diskon'  => $request->nilai_diskon,
        'berat'         => $request->berat ?? '',
        'satuan'        => $request->satuan ?? '',
        'tampil_transaksi'        => $request->tampil_transaksi,
    ]);

    if ($request->tipe_stok == 1) {
        data_stok::create([
            'id_barangs'   => $barang->id,
            'created_at'   => ($request->created_at != null) ? $request->created_at : now(),
            'expired_at'  => $request->expired_at ?? null,
            'stok'        => $request->stok,
            'harga_dasar' => $request->harga_dasar,
        ]);
    }

    return response()->json([
        'message' => 'Barang berhasil ditambahkan',
        'data' => $barang,
    ], 201);
    }

    // Detail barang
    public function show($id, Request $request)
    {
        $barang = barangs::where('id_users', $request->user()->id)->findOrFail($id);
        return response()->json($barang, 200);
    }

    // Update barang
    public function update(Request $request, $id)
    {
        $barang = barangs::where('id_users', $request->user()->id)->findOrFail($id);

        $request->validate([
            'kode_barang'   => 'sometimes|string|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang'   => 'sometimes|string',
            'tipe_barang'   => 'sometimes|in:default,addon',
            'tipe_stok'     => 'sometimes|numeric',
            'stok'          => 'sometimes|numeric',
            'harga_dasar'   => 'sometimes|numeric',
            'harga_jual'    => 'sometimes|numeric',
            'nama_kategori' => 'sometimes|string',
            'tipe_diskon'   => 'sometimes|numeric',
            'nilai_diskon'  => 'sometimes|numeric',
            'berat'         => 'sometimes|string',
            'satuan'        => 'sometimes|string',
        ]);

        $barang->update(array_merge(
            $request->all(),
            ['kode_barang' => $request->kode_barang ? strtoupper($request->kode_barang) : $barang->kode_barang]
        ));

        return response()->json([
            'message' => 'Barang berhasil diperbarui',
            'data' => $barang
        ], 200);
    }

    // Hapus barang
    public function destroy($id, Request $request)
    {
        $barang = barangs::where('id_users', $request->user()->id)->findOrFail($id);
        $barang->delete();

        return response()->json([
            'message' => 'Barang berhasil dihapus'
        ], 200);
    }
}
