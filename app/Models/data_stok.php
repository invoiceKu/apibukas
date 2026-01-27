<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class data_stok extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'data_stok';

    protected $fillable = [
        'id_users',
        'id_barangs',
        'stok',
        'harga_dasar',
        'expired_at',
    ];

    /**
     * Relasi ke tabel barangs
     */
    public function barang()
    {
        return $this->belongsTo(barangs::class, 'id_barangs');
    }

    /**
     * Relasi ke tabel users
     */
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
            ->logOnly(['id_barangs', 'stok', 'harga_dasar', 'expired_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Data Stok {$eventName}");
    }
}
