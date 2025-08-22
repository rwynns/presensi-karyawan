<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'user_id',
        'lokasi_penempatan_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'latitude_masuk',
        'longitude_masuk',
        'latitude_keluar',
        'longitude_keluar',
        'jarak_masuk',
        'jarak_keluar',
        'foto_masuk',
        'foto_keluar',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i:s',
        'jam_keluar' => 'datetime:H:i:s'
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with LokasiPenempatan
     */
    public function lokasiPenempatan()
    {
        return $this->belongsTo(LokasiPenempatan::class, 'lokasi_penempatan_id');
    }

    /**
     * Determine if the attendance is late
     *
     * @return bool
     */
    public function isLate()
    {
        if (!$this->jam_masuk) {
            return false;
        }

        if ($this->lokasiPenempatan && $this->lokasiPenempatan->jam_masuk) {
            $scheduledTime = Carbon::parse($this->lokasiPenempatan->jam_masuk);
            $actualTime = Carbon::parse($this->jam_masuk->format('H:i:s'));
            return $actualTime->gt($scheduledTime);
        }

        // Default to 08:00:00 if no schedule is set
        $defaultTime = Carbon::parse('08:00:00');
        $actualTime = Carbon::parse($this->jam_masuk->format('H:i:s'));
        return $actualTime->gt($defaultTime);
    }
}
