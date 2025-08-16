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
        'jam_masuk',
        'jam_pulang',
        'toleransi_keterlambatan',
        'description'
    ];

    protected $casts = [
        'jam_masuk' => 'datetime:H:i',
        'jam_pulang' => 'datetime:H:i',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Check if current time is late based on jam_masuk and toleransi_keterlambatan
     */
    public function isLate($currentTime = null)
    {
        if (!$currentTime) {
            $currentTime = now()->format('H:i:s');
        }

        $jamMasukWithToleransi = $this->jam_masuk->addMinutes($this->toleransi_keterlambatan);
        $currentDateTime = now()->setTimeFromTimeString($currentTime);

        return $currentDateTime->gt($jamMasukWithToleransi);
    }

    /**
     * Get formatted working hours
     */
    public function getFormattedWorkingHours()
    {
        return $this->jam_masuk->format('H:i') . ' - ' . $this->jam_pulang->format('H:i');
    }

    // Relationship with User
    public function users()
    {
        return $this->hasMany(User::class, 'lokasi_id');
    }
}
