<!-- Map Provider Status Component -->
@php
    $serviceInfo = \App\Services\MapServiceFactory::getServiceInfo();
    $configErrors = \App\Services\MapServiceFactory::validateConfiguration();
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Map Provider Status</h3>
        <div class="flex items-center space-x-2">
            @if ($serviceInfo['service'] === 'OpenStreetMap')
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $serviceInfo['service'] }}
                </span>
            @else
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $serviceInfo['service'] }}
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <span class="text-gray-600">Cost:</span>
            <span class="font-medium text-gray-900">{{ $serviceInfo['cost'] }}</span>
        </div>
        <div>
            <span class="text-gray-600">Accuracy:</span>
            <span class="font-medium text-gray-900">{{ $serviceInfo['accuracy'] }}</span>
        </div>
        <div>
            <span class="text-gray-600">Search:</span>
            <span class="font-medium text-gray-900">{{ $serviceInfo['search_provider'] }}</span>
        </div>
        <div>
            <span class="text-gray-600">API Key:</span>
            @if ($serviceInfo['requires_api_key'])
                @if ($serviceInfo['api_key_configured'])
                    <span class="font-medium text-green-600">✓ Configured</span>
                @else
                    <span class="font-medium text-red-600">✗ Missing</span>
                @endif
            @else
                <span class="font-medium text-gray-500">Not required</span>
            @endif
        </div>
    </div>

    @if (!empty($configErrors))
        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-red-800">Configuration Issues</h4>
                    <div class="mt-1">
                        @foreach ($configErrors as $error)
                            <p class="text-sm text-red-700">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-green-800">Configuration Valid</h4>
                    <p class="text-sm text-green-700">Map service is properly configured and ready to use.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="flex items-center justify-between text-xs text-gray-500">
            <span>Switch providers using: <code class="bg-gray-100 px-1 rounded">php artisan map:provider
                    switch</code></span>
            <a href="{{ route('admin.lokasi-penempatan.index') }}" class="text-blue-600 hover:text-blue-800">
                Manage Locations →
            </a>
        </div>
    </div>
</div>
