<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izin';

    protected $fillable = [
        'user_id',
        'jenis_izin',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_masuk_maksimal',
        'jam_pulang_awal',
        'is_hari_ini',
        'alasan',
        'file_pendukung',
        'status',
        'keterangan_admin'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_hari_ini' => 'boolean'
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias for approver relationship - returns null since approval tracking is not in current migration
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by_user_id'); // This column doesn't exist, will return null
    }

    /**
     * Get status color class
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'disetujui' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get jenis izin label
     */
    public function getJenisIzinLabelAttribute()
    {
        return match ($this->jenis_izin) {
            'sakit' => 'Sakit',
            'cuti' => 'Cuti',
            'keperluan_keluarga' => 'Keperluan Keluarga',
            'keperluan_pribadi' => 'Keperluan Pribadi',
            'izin_masuk_terlambat' => 'Izin Masuk Terlambat',
            'izin_pulang_awal' => 'Izin Pulang Awal',
            'lainnya' => 'Lainnya',
            default => ucfirst($this->jenis_izin)
        };
    }

    /**
     * Get duration in days
     */
    public function getDurasiAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
    }

    /**
     * Get document file name for display
     */
    public function getDokumenAttribute()
    {
        return $this->file_pendukung;
    }

    /**
     * Check if this is a time-based permission (late arrival or early departure)
     */
    public function isTimeBasedPermission()
    {
        return in_array($this->jenis_izin, ['izin_masuk_terlambat', 'izin_pulang_awal']);
    }

    /**
     * Get approved time-based permission for user today
     */
    public static function getTodayTimePermission($userId, $jenisIzin)
    {
        return static::where('user_id', $userId)
            ->where('jenis_izin', $jenisIzin)
            ->where('tanggal_mulai', '<=', today())
            ->where('tanggal_selesai', '>=', today())
            ->where('status', 'disetujui')
            ->first();
    }

    /**
     * Check if user has approved late arrival permission today
     */
    public static function hasLateArrivalPermissionToday($userId)
    {
        return static::getTodayTimePermission($userId, 'izin_masuk_terlambat') !== null;
    }

    /**
     * Check if user has approved early departure permission today
     */
    public static function hasEarlyDeparturePermissionToday($userId)
    {
        return static::getTodayTimePermission($userId, 'izin_pulang_awal') !== null;
    }
}
