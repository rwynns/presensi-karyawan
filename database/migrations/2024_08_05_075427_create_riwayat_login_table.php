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
        Schema::create('riwayat_login', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->datetime('login_time');
            $table->string('ip_address', 100);
            $table->text('lokasi_login');
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index('user_id');
            $table->index('login_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_login');
    }
};
