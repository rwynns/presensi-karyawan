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
        Schema::table('users', function (Blueprint $table) {
            // Add new fields to existing users table
            $table->string('jabatan', 100)->nullable()->after('email');
            $table->text('alamat')->nullable()->after('jabatan');
            $table->unsignedBigInteger('role_id')->nullable()->after('alamat');
            $table->unsignedBigInteger('lokasi_id')->nullable()->after('role_id');
            $table->unsignedBigInteger('jabatan_id')->nullable()->after('lokasi_id');

            // Add foreign key constraints
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->foreign('lokasi_id')->references('id')->on('lokasi_penempatan')->onDelete('set null');
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('set null');

            // Add indexes for better performance
            $table->index('role_id');
            $table->index('lokasi_id');
            $table->index('jabatan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['role_id']);
            $table->dropForeign(['lokasi_id']);
            $table->dropForeign(['jabatan_id']);

            // Drop indexes
            $table->dropIndex(['role_id']);
            $table->dropIndex(['lokasi_id']);
            $table->dropIndex(['jabatan_id']);

            // Drop columns
            $table->dropColumn(['jabatan', 'alamat', 'role_id', 'lokasi_id', 'jabatan_id']);
        });
    }
};
