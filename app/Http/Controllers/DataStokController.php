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
            'id_barangs' => 'required|exists:barangs,id',
            'stok' => 'required|numeric|min:0.01',
            'harga_dasar' => 'required|numeric|min:0',
            'created_at' => 'nullable|date',
            'expired_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
        ]);

        // Buat data stok baru
        $dataStok = data_stok::create([
            'id_barangs' => $request->id_barangs,
            'stok' => $request->stok,
            'harga_dasar' => $request->harga_dasar,
            'created_at' => $request->created_at ?? now(),
            'expired_at' => $request->expired_at,
            'updated_at' => $request->updated_at ?? now(),
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
                'id_barangs' => $dataStok->id_barangs,
                'stok' => $dataStok->stok,
                'harga_dasar' => $dataStok->harga_dasar,
                'created_at' => $dataStok->created_at,
                'expired_at' => $dataStok->expired_at,
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
                    'id_barangs' => $item->id_barangs,
                    'stok' => $item->stok,
                    'harga_dasar' => $item->harga_dasar,
                    'created_at' => $item->created_at,
                    'expired_at' => $item->expired_at,
                    'updated_at' => $item->updated_at,
                ];
            })
        ], 200);
    }
}
