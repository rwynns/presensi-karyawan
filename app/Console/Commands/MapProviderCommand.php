<?php

namespace App\Console\Commands;

use App\Services\MapServiceFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MapProviderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'map:provider 
                            {action : The action to perform (switch, status, validate)}
                            {--provider= : Map provider to switch to (google, osm)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage map provider configuration (Google Maps or OpenStreetMap)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'switch':
                return $this->switchProvider();
            case 'status':
                return $this->showStatus();
            case 'validate':
                return $this->validateConfiguration();
            default:
                $this->error("Unknown action: {$action}");
                $this->info('Available actions: switch, status, validate');
                return 1;
        }
    }

    private function switchProvider()
    {
        $provider = $this->option('provider');

        if (!$provider) {
            $provider = $this->choice(
                'Which map provider would you like to use?',
                ['google' => 'Google Maps', 'osm' => 'OpenStreetMap'],
                'osm'
            );
        }

        $useOsm = ($provider === 'osm');

        // Update .env file
        $envPath = base_path('.env');

        if (File::exists($envPath)) {
            $envContents = File::get($envPath);

            // Update or add USE_OPENSTREETMAP
            if (str_contains($envContents, 'USE_OPENSTREETMAP=')) {
                $envContents = preg_replace(
                    '/USE_OPENSTREETMAP=.*/',
                    'USE_OPENSTREETMAP=' . ($useOsm ? 'true' : 'false'),
                    $envContents
                );
            } else {
                $envContents .= "\nUSE_OPENSTREETMAP=" . ($useOsm ? 'true' : 'false') . "\n";
            }

            File::put($envPath, $envContents);

            $providerName = $useOsm ? 'OpenStreetMap' : 'Google Maps';
            $this->info("✅ Successfully switched to {$providerName}!");

            if (!$useOsm) {
                $apiKey = env('GOOGLE_MAPS_API_KEY');
                if (empty($apiKey) || $apiKey === 'your_google_maps_api_key_here') {
                    $this->warn('⚠️  Google Maps API key is not configured.');
                    $this->info('Please set GOOGLE_MAPS_API_KEY in your .env file.');
                    $this->info('See GOOGLE_MAPS_SETUP.md for instructions.');
                }
            }

            $this->info('💡 Please run: php artisan config:clear');
        } else {
            $this->error('❌ .env file not found');
            return 1;
        }

        return 0;
    }

    private function showStatus()
    {
        $serviceInfo = MapServiceFactory::getServiceInfo();

        $this->info('📍 Current Map Provider Status:');
        $this->table(
            ['Property', 'Value'],
            [
                ['Service', $serviceInfo['service']],
                ['Requires API Key', $serviceInfo['requires_api_key'] ? 'Yes' : 'No'],
                ['API Key Configured', $serviceInfo['api_key_configured'] ? 'Yes' : 'No'],
                ['Cost', $serviceInfo['cost']],
                ['Accuracy', $serviceInfo['accuracy']],
                ['Search Provider', $serviceInfo['search_provider']],
            ]
        );

        // Show configuration errors if any
        $errors = MapServiceFactory::validateConfiguration();
        if (!empty($errors)) {
            $this->error('❌ Configuration Issues:');
            foreach ($errors as $error) {
                $this->line("  • {$error}");
            }
        } else {
            $this->info('✅ Configuration is valid');
        }

        return 0;
    }

    private function validateConfiguration()
    {
        $errors = MapServiceFactory::validateConfiguration();
        $serviceInfo = MapServiceFactory::getServiceInfo();

        $this->info("🔍 Validating {$serviceInfo['service']} configuration...");

        if (empty($errors)) {
            $this->info('✅ All configuration is valid!');

            // Additional checks
            $this->info('📋 Configuration Details:');
            $this->line("  • Map Service: {$serviceInfo['service']}");
            $this->line("  • API Key Required: " . ($serviceInfo['requires_api_key'] ? 'Yes' : 'No'));

            if ($serviceInfo['requires_api_key']) {
                $this->line("  • API Key Configured: " . ($serviceInfo['api_key_configured'] ? 'Yes' : 'No'));
            }

            $this->line("  • Search Provider: {$serviceInfo['search_provider']}");
            $this->line("  • Cost: {$serviceInfo['cost']}");

            return 0;
        } else {
            $this->error('❌ Configuration validation failed:');
            foreach ($errors as $error) {
                $this->line("  • {$error}");
            }

            $this->info('');
            $this->info('🔧 Suggested fixes:');

            if (str_contains(implode(' ', $errors), 'API key')) {
                $this->line('  • Set GOOGLE_MAPS_API_KEY in your .env file');
                $this->line('  • See GOOGLE_MAPS_SETUP.md for detailed instructions');
                $this->line('  • Or switch to OpenStreetMap: php artisan map:provider switch --provider=osm');
            }

            return 1;
        }
    }
}
