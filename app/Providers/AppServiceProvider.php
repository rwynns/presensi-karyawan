<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure application uses the configured timezone and locale at runtime
        try {
            date_default_timezone_set(config('app.timezone'));
            Carbon::setLocale(config('app.locale', 'id'));
        } catch (\Throwable $e) {
            // No-op if PHP or Carbon timezone/locale fail for any reason
        }

        // Align MySQL session time zone so TIMESTAMP columns are stored/displayed in WIB (+07:00)
        try {
            DB::statement("SET time_zone = '+07:00'");
        } catch (\Throwable $e) {
            // Ignore if database does not support named time zones or statement fails
        }
    }
}
