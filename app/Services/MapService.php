<?php

namespace App\Services;

interface MapServiceInterface
{
    public function getCreateView(): string;
    public function getEditView(): string;
    public function getShowView(): string;
    public function requiresApiKey(): bool;
    public function getApiKeyConfigPath(): ?string;
}

class GoogleMapsService implements MapServiceInterface
{
    public function getCreateView(): string
    {
        return 'admin.lokasi-penempatan.create';
    }

    public function getEditView(): string
    {
        return 'admin.lokasi-penempatan.edit';
    }

    public function getShowView(): string
    {
        return 'admin.lokasi-penempatan.show';
    }

    public function requiresApiKey(): bool
    {
        return true;
    }

    public function getApiKeyConfigPath(): ?string
    {
        return 'services.google.maps_api_key';
    }
}

class OpenStreetMapService implements MapServiceInterface
{
    public function getCreateView(): string
    {
        return 'admin.lokasi-penempatan.create-osm';
    }

    public function getEditView(): string
    {
        return 'admin.lokasi-penempatan.edit-osm';
    }

    public function getShowView(): string
    {
        return 'admin.lokasi-penempatan.show-osm';
    }

    public function requiresApiKey(): bool
    {
        return false;
    }

    public function getApiKeyConfigPath(): ?string
    {
        return null;
    }
}

class MapServiceFactory
{
    public static function create(): MapServiceInterface
    {
        $useOpenStreetMap = config('app.use_openstreetmap', false);

        if ($useOpenStreetMap) {
            return new OpenStreetMapService();
        }

        return new GoogleMapsService();
    }

    public static function validateConfiguration(): array
    {
        $service = self::create();
        $errors = [];

        if ($service->requiresApiKey()) {
            $apiKey = config($service->getApiKeyConfigPath());

            if (empty($apiKey) || $apiKey === 'your_google_maps_api_key_here') {
                $errors[] = 'Google Maps API key is required but not configured. Please set GOOGLE_MAPS_API_KEY in your .env file.';
            }
        }

        return $errors;
    }

    public static function getServiceInfo(): array
    {
        $service = self::create();
        $isOpenStreetMap = $service instanceof OpenStreetMapService;

        return [
            'service' => $isOpenStreetMap ? 'OpenStreetMap' : 'Google Maps',
            'requires_api_key' => $service->requiresApiKey(),
            'api_key_configured' => $service->requiresApiKey() ? !empty(config($service->getApiKeyConfigPath())) : true,
            'cost' => $isOpenStreetMap ? 'Free' : 'Paid after quota',
            'accuracy' => $isOpenStreetMap ? 'Good' : 'Excellent',
            'search_provider' => $isOpenStreetMap ? 'Nominatim' : 'Google Places API',
        ];
    }
}
