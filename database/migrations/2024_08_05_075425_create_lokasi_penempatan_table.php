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
        Schema::create('lokasi_penempatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi', 100);
            $table->text('alamat_lengkap');
            $table->decimal('latitude', 10, 8)->nullable(); // Koordinat GPS latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Koordinat GPS longitude
            $table->integer('radius')->default(50); // Radius dalam meter untuk validasi presensi
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->text('description')->nullable(); // Deskripsi tambahan lokasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_penempatan');
    }
};
