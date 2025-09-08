<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Role;

class ResetTestingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testing:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset testing data (hapus karyawan testing dan absensi mereka)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧹 Menghapus data testing...');

        // Email testing yang akan dihapus
        $testingEmails = [
            'ahmad.rizki@company.com',
            'siti.nurhaliza@company.com',
            'budi.santoso@company.com',
            'maya.sari@company.com',
            'eko.prasetyo@company.com'
        ];

        // Hapus absensi dari karyawan testing
        $deletedAbsensi = 0;
        foreach ($testingEmails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $count = Absensi::where('user_id', $user->id)->count();
                Absensi::where('user_id', $user->id)->delete();
                $deletedAbsensi += $count;
            }
        }

        // Hapus karyawan testing
        $deletedUsers = User::whereIn('email', $testingEmails)->delete();

        $this->info("✅ Berhasil menghapus:");
        $this->info("   - {$deletedUsers} karyawan testing");
        $this->info("   - {$deletedAbsensi} record absensi");

        $this->info("🔄 Untuk membuat ulang data testing, jalankan:");
        $this->info("   php artisan db:seed --class=KaryawanAbsensiSeeder");

        return 0;
    }
}
