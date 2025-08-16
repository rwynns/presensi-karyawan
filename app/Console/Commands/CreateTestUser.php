<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LokasiPenempatan;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for attendance system testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating test user...');

        // Get first location for assignment
        $lokasi = LokasiPenempatan::first();

        if (!$lokasi) {
            $this->error('No location found! Please run the LokasiPenempatanSeeder first.');
            return 1;
        }

        // Create or update test user
        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'nama' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 2, // Karyawan
                'lokasi_id' => $lokasi->id,
                'jabatan_id' => 1,
                'is_active' => true
            ]
        );

        $this->info('Test user created/updated successfully!');
        $this->table(
            ['Field', 'Value'],
            [
                ['Email', 'test@example.com'],
                ['Password', 'password123'],
                ['Assigned Location', $lokasi->nama_lokasi],
                ['Location ID', $lokasi->id],
                ['Coordinates', $lokasi->latitude . ', ' . $lokasi->longitude],
                ['Radius', $lokasi->radius . 'm'],
            ]
        );

        $this->info('You can now login and test the attendance system.');

        return 0;
    }
}
