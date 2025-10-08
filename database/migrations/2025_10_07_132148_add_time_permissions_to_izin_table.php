<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('izin', function (Blueprint $table) {
            // Untuk izin masuk terlambat - sampai jam berapa bisa masuk
            $table->time('jam_masuk_maksimal')->nullable()->after('tanggal_selesai');

            // Untuk izin pulang awal - jam berapa boleh pulang
            $table->time('jam_pulang_awal')->nullable()->after('jam_masuk_maksimal');

            // Menandai apakah izin ini untuk hari ini (untuk quick access)
            $table->boolean('is_hari_ini')->default(false)->after('jam_pulang_awal');

            // Index untuk performa
            $table->index(['tanggal_mulai', 'is_hari_ini']);
            $table->index(['user_id', 'tanggal_mulai', 'jenis_izin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin', function (Blueprint $table) {
            $table->dropIndex(['tanggal_mulai', 'is_hari_ini']);
            $table->dropIndex(['user_id', 'tanggal_mulai', 'jenis_izin']);
            $table->dropColumn(['jam_masuk_maksimal', 'jam_pulang_awal', 'is_hari_ini']);
        });
    }
};
