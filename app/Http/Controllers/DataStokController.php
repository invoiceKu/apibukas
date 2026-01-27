<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\data_stok;
use App\Models\barangs;

class DataStokController extends Controller
{
    /**
     * Tambah data stok barang baru
     */
    public function tambahStok(Request $request)
    {
        $request->validate([
            'id_users' => 'required|exists:users,id',
            'id_barangs' => 'required|exists:barangs,id',
            'stok' => 'required|numeric|min:0.01',
            'harga_dasar' => 'required|numeric|min:0',
            'expired_at' => 'nullable|date',
        ]);

        // Buat data stok baru
        $dataStok = data_stok::create([
            'id_users' => $request->id_users,
            'id_barangs' => $request->id_barangs,
            'stok' => $request->stok,
            'harga_dasar' => $request->harga_dasar,
            'expired_at' => $request->expired_at,
        ]);

        // Update total stok di tabel barangs
        $barang = barangs::find($request->id_barangs);
        if ($barang) {
            $totalStok = data_stok::where('id_barangs', $request->id_barangs)->sum('stok');
            $barang->stok = $totalStok;
            $barang->save();
        }

        return response()->json([
            'message' => 'Data stok berhasil ditambahkan',
            'data' => [
                'id' => $dataStok->id,
                'id_users' => $dataStok->id_users,
                'id_barangs' => $dataStok->id_barangs,
                'stok' => $dataStok->stok,
                'harga_dasar' => $dataStok->harga_dasar,
                'expired_at' => $dataStok->expired_at,
                'created_at' => $dataStok->created_at,
                'updated_at' => $dataStok->updated_at,
            ]
        ], 201);
    }

    /**
     * Kurangi stok barang berdasarkan id_barangs dengan metode FIFO atau FEFO
     */
    public function kurangiStok(Request $request)
    {
        $request->validate([
            'id_barangs' => 'required|exists:barangs,id',
            'stok' => 'required|numeric|min:0.01',
            'stok_mode' => 'required|string|in:fifo,fefo',
        ]);

        // Cari semua data stok berdasarkan id_barangs
        $allDataStok = data_stok::where('id_barangs', $request->id_barangs)->get();

        // Cek apakah ada data stok untuk barang ini
        if ($allDataStok->isEmpty()) {
            return response()->json([
                'message' => 'Tidak dapat dikurangi, Stok sudah habis.'
            ], 404);
        }

        // Hitung total stok tersedia
        $totalStok = $allDataStok->sum('stok');

        // Cek apakah total stok cukup
        if ($totalStok < $request->stok) {
            return response()->json([
                'message' => 'Stok tidak mencukupi.',
                'stok_tersedia' => $totalStok,
                'stok_diminta' => $request->stok,
            ], 400);
        }

        // Urutkan data stok berdasarkan mode
        if ($request->stok_mode == 'fifo') {
            // FIFO: urutkan berdasarkan created_at paling awal
            $sortedStok = $allDataStok->sortBy('created_at');
        } else {
            // FEFO: urutkan berdasarkan expired_at paling awal
            $sortedStok = $allDataStok->sortBy('expired_at');
        }

        // Kurangi stok
        $sisaStokDikurangi = $request->stok;

        foreach ($sortedStok as $dataStok) {
            if ($sisaStokDikurangi <= 0) {
                break;
            }

            if ($dataStok->stok >= $sisaStokDikurangi) {
                // Stok di record ini cukup untuk memenuhi sisa
                $dataStok->stok -= $sisaStokDikurangi;
                $sisaStokDikurangi = 0;
            } else {
                // Ambil semua stok dari record ini
                $sisaStokDikurangi -= $dataStok->stok;
                $dataStok->stok = 0;
            }

            $dataStok->save();
        }

        // Update total stok di tabel barangs
        $barang = barangs::find($request->id_barangs);
        if ($barang) {
            $totalStok = data_stok::where('id_barangs', $request->id_barangs)->sum('stok');
            $barang->stok = $totalStok;
            $barang->save();
        }

        // Ambil semua data stok terbaru untuk response
        $updatedDataStok = data_stok::where('id_barangs', $request->id_barangs)->get();

        return response()->json([
            'message' => 'Stok berhasil dikurangi',
            'data' => $updatedDataStok->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_users' => $item->id_users,
                    'id_barangs' => $item->id_barangs,
                    'stok' => $item->stok,
                    'harga_dasar' => $item->harga_dasar,
                    'expired_at' => $item->expired_at,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            })
        ], 200);
    }

    /**
     * Get all data stok berdasarkan id_users dari token
     */
    public function getAllStokByUser(Request $request)
    {
        // Ambil user dari token authentication
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Token tidak valid atau tidak ditemukan.'
            ], 401);
        }

        // Ambil semua data stok berdasarkan id_users dengan relasi barang
        $dataStok = data_stok::where('id_users', $user->id)
            ->with('barang')
            ->orderBy('created_at', 'desc')
            ->get();

        // Cek apakah data stok kosong
        if ($dataStok->isEmpty()) {
            return response()->json([
                'message' => 'Data stok tidak ditemukan',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Data stok berhasil diambil',
            'total_records' => $dataStok->count(),
            'data' => $dataStok->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_users' => $item->id_users,
                    'id_barangs' => $item->id_barangs,
                    'stok' => $item->stok,
                    'harga_dasar' => $item->harga_dasar,
                    'expired_at' => $item->expired_at,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            })
        ], 200);
    }
}
