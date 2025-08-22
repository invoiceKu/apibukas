<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'id_users',
        'company_name',
        'company_address',
        'company_owners',
        'company_telp',
        'motto',
        'pajak_default',
        'sub_business',
        'currency',
        'currency_code',
        'currency_country',
        'stok_mode',
        'negara',
        'provinsi',
        'kota',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'pajak_default' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
