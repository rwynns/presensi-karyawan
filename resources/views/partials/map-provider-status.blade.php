<!-- Map Provider Status Component -->
<div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-4 text-white shadow-md">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            @if (config('services.maps.default') === 'google')
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold">Google Maps</h4>
                    <p class="text-xs opacity-90">Provider peta aktif</p>
                </div>
            @else
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        <circle cx="12" cy="9" r="1" fill="white" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold">OpenStreetMap</h4>
                    <p class="text-xs opacity-90">Provider peta aktif</p>
                </div>
            @endif
        </div>

        <div class="text-right">
            <div class="flex items-center space-x-1">
                <div class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></div>
                <span class="text-xs font-medium">Aktif</span>
            </div>
            <button onclick="showMapProviderInfo()"
                class="text-xs text-indigo-200 hover:text-white transition-colors duration-200 underline mt-1">
                Info Selengkapnya
            </button>
        </div>
    </div>
</div>

<script>
    function showMapProviderInfo() {
        const currentProvider = '{{ config('services.maps.default') }}';
        const providerName = currentProvider === 'google' ? 'Google Maps' : 'OpenStreetMap';
        const switchCommand = currentProvider === 'google' ? 'openstreetmap' : 'google';

        Swal.fire({
            title: `${providerName} Aktif`,
            html: `
            <div class="text-left space-y-3">
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="font-semibold text-gray-800 mb-2">Provider Saat Ini:</p>
                    <p class="text-sm text-gray-600">${providerName}</p>
                </div>
                
                <div class="bg-blue-50 p-3 rounded-lg">
                    <p class="font-semibold text-blue-800 mb-2">Untuk Mengganti Provider:</p>
                    <code class="text-xs bg-gray-800 text-green-400 px-2 py-1 rounded block">
                        php artisan map:provider switch ${switchCommand}
                    </code>
                </div>
                
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <p class="font-semibold text-yellow-800 mb-2">Perintah Lainnya:</p>
                    <div class="space-y-1 text-xs">
                        <code class="bg-gray-800 text-green-400 px-2 py-1 rounded block">php artisan map:provider status</code>
                        <code class="bg-gray-800 text-green-400 px-2 py-1 rounded block">php artisan map:provider validate</code>
                    </div>
                </div>
            </div>
        `,
            icon: 'info',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#6366f1',
            width: '500px'
        });
    }
</script>
