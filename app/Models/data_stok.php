<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_stok extends Model
{
    use HasFactory;

    protected $table = 'data_stok';

    protected $fillable = [
        'id_barangs',
        'stok',
        'harga_dasar',
        'created_at',
        'expired_at',
    ];

    // relasi ke barang
    public function barang()
    {
        return $this->belongsTo(barangs::class, 'id_barangs');
    }
}
