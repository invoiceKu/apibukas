<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Kategori extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id_users',
        'nama_kategori',
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
            ->logOnly(['nama_kategori'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Kategori {$eventName}");
    }
}
