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
        'alasan',
        'file_pendukung',
        'status',
        'keterangan_admin'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date'
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
}
