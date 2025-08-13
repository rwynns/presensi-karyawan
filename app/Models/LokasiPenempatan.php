<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPenempatan extends Model
{
    use HasFactory;

    protected $table = 'lokasi_penempatan';

    protected $fillable = [
        'nama_lokasi',
        'alamat_lengkap',
        'latitude',
        'longitude',
        'radius',
        'description'
    ];

    // Relationship with User
    public function users()
    {
        return $this->hasMany(User::class, 'lokasi_id');
    }
}
