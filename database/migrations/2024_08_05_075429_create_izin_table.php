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
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('jenis_izin', 50); // sakit, cuti, izin_khusus, dll
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('alasan');
            $table->string('file_pendukung', 255)->nullable(); // dokumen pendukung
            $table->string('status', 20)->default('pending'); // pending, approved, rejected
            $table->text('keterangan_admin')->nullable(); // catatan dari admin
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes for better performance
            $table->index('user_id');
            $table->index('tanggal_mulai');
            $table->index('tanggal_selesai');
            $table->index('status');
            $table->index('jenis_izin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
