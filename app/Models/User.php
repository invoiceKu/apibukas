<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'no_hp',
        'expired_user',
        'paket_1',
        'paket1_at',
        'paket_2',
        'paket2_at',
        'paket_3',
        'paket3_at',
        'type_user',
        'foto_profil',
        'versi',
        'saldo',
        'saldo_referral',
        'storage_size',
        'desktop_plugin',
        'desktop_at',
        'status_hp',
        'device_name',
        'device_type',
        'os_version',
        'api_token',
        'nomor_struk',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function company()
    {
        return $this->hasOne(Company::class, 'id_users');
    }
}
