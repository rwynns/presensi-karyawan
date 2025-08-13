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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lokasi_penempatan_id'); // Referensi ke lokasi kerja
            $table->date('tanggal');

            // Data absen masuk
            $table->time('jam_masuk')->nullable();
            $table->decimal('latitude_masuk', 10, 8)->nullable(); // GPS saat masuk
            $table->decimal('longitude_masuk', 11, 8)->nullable(); // GPS saat masuk
            $table->integer('jarak_masuk')->nullable(); // Jarak dari lokasi kantor saat masuk (meter)

            // Data absen keluar
            $table->time('jam_keluar')->nullable();
            $table->decimal('latitude_keluar', 10, 8)->nullable(); // GPS saat keluar
            $table->decimal('longitude_keluar', 11, 8)->nullable(); // GPS saat keluar
            $table->integer('jarak_keluar')->nullable(); // Jarak dari lokasi kantor saat keluar (meter)

            // Status kehadiran
            $table->enum('status', ['masuk', 'keluar', 'izin']);
            $table->text('keterangan')->nullable(); // Keterangan tambahan jika diperlukan

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lokasi_penempatan_id')->references('id')->on('lokasi_penempatan')->onDelete('cascade');

            // Indexes for better performance
            $table->index('user_id');
            $table->index('lokasi_penempatan_id');
            $table->index('tanggal');
            $table->index('status');
            $table->index(['user_id', 'tanggal']); // Composite index for common queries
            $table->unique(['user_id', 'tanggal']); // Ensure one record per user per day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
