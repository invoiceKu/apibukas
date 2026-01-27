<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class barangs extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id_users',
        'foto_barang',
        'nama_barang',
        'kode_barang',
        'tipe_barang',
        'tipe_stok',
        'stok',
        'harga_dasar',
        'harga_jual',
        'nama_kategori',
        'tipe_diskon',
        'nilai_diskon',
        'berat',
        'satuan',
        'tampil_transaksi'
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    /**
     * Activity Log Configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama_barang', 'kode_barang', 'stok', 'harga_dasar', 'harga_jual', 'nama_kategori', 'tipe_barang', 'satuan'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Barang {$eventName}");
    }
}
