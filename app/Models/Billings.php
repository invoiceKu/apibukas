<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billings extends Model
{
    //
    protected $fillable = [
        'id_users',
        'waktu_awal',
        'waktu_akhir',
        'storage_size',
        'total_staff',
        'pro',
        'jumlah_bulan',
        'total',
        'tipe',
        'status',
        'detail',
        'invoice',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
