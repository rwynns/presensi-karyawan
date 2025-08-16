<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'jabatan',
        'alamat',
        'role_id',
        'lokasi_id',
        'jabatan_id',
        'is_active'
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relationship with Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Relationship with Jabatan
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    /**
     * Relationship with Jabatan (alias for backward compatibility)
     */
    public function jabatanRelation()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    /**
     * Relationship with Lokasi Penempatan
     */
    public function lokasiPenempatan()
    {
        return $this->belongsTo(LokasiPenempatan::class, 'lokasi_id');
    }

    /**
     * Relationship with Lokasi Penempatan (alias for backward compatibility)
     */
    public function lokasi()
    {
        return $this->belongsTo(LokasiPenempatan::class, 'lokasi_id');
    }

    /**
     * Relationship with Absensi
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'user_id');
    }

    /**
     * Relationship with Izin
     */
    public function izin()
    {
        return $this->hasMany(Izin::class, 'user_id');
    }
}
