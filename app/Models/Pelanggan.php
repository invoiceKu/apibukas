<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pelanggan extends Model
{
    use HasFactory, LogsActivity;

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

    /**
     * Activity Log Configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama_pelanggan', 'email_pelanggan', 'no_pelanggan', 'kode_pelanggan', 'alamat_pelanggan', 'saldo_pelanggan', 'poin_pelanggan'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Pelanggan {$eventName}");
    }
}
