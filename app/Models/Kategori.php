<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    protected $fillable = [
        'id_users',
        'nama_kategori',
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
