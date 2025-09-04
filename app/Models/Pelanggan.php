<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    //
    protected $fillable = [
        'id_users',
        'nama_pelanggan',
        'email_pelanggan',
        'no_pelanggan',
        'kode_pelanggan',
        'alamat_pelanggan',
        'foto_pelanggan',
        'saldo_pelanggan',
        'poin_pelanggan',
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
