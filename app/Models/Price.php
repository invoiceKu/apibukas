<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'price'; // 👈 ini penting, sesuaikan dengan nama tabel sebenarnya

    // (opsional) jika tabel tidak punya kolom created_at / updated_at
    public $timestamps = false;

    // (opsional) jika kamu pakai mass assignment
    protected $fillable = ['nama', 'harga'];
}
