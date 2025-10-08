@extends('layouts.main')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-primary-500 via-primary-600 to-secondary-500 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-complimentary-400/10 rounded-full blur-2xl"></div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-6xl">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left: Header + Status -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Header Card -->
                        <div
                            class="bg-white/95 backdrop-blur-md rounded-3xl p-8 shadow-2xl shadow-black/10 border border-white/20">
                            <div class="flex items-start justify-between gap-6 flex-col md:flex-row">
                                <div class="flex-1 min-w-0">
                                    <div class="mb-2 text-center">
                                        <p class="text-xl font-bold font-sans tracking-wider text-black font-inter">Selamat
                                            datang
                                            {{ Auth::user()->nama }}!
                                        </p>
                                    </div>

                                    <!-- Date & Location -->
                                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div
                                            class="flex items-center justify-between bg-white/95 rounded-2xl p-4 border border-gray-100">
                                            <div class="flex items-center space-x-3">
                                                <div class="p-2 bg-primary-500 rounded-xl">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="w-6 h-6 text-white">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-lg font-poppins font-semibold text-gray-800">
                                                        {{ now()->timezone(config('app.timezone'))->translatedFormat('d F Y') }}
                                                    </p>
                                                    <p class="text-sm font-inter text-gray-600">
                                                        {{ now()->timezone(config('app.timezone'))->translatedFormat('l') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="locationInfo"
                                            class="text-right hidden bg-white/95 rounded-2xl p-4 border border-gray-100">
                                            <h4 class="text-sm font-poppins font-semibold text-gray-700 mb-1">Lokasi
                                                Penempatan</h4>
                                            <p id="locationName" class="text-xs font-inter text-gray-600">Memuat...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Card -->
                        <div
                            class="bg-white/90 backdrop-blur-md rounded-2xl p-6 shadow-xl shadow-black/5 border border-white/20">
                            <div class="text-center">
                                <h3 class="text-lg font-poppins font-semibold text-gray-800 mb-2">Status Hari Ini</h3>
                                <div id="statusContent" class="flex items-center justify-center space-x-2">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                                    <p class="text-sm font-inter text-gray-600">Memuat status...</p>
                                </div>
                                <div id="attendanceInfo" class="mt-3 text-sm text-gray-600 hidden">
                                    <div id="jamMasukInfo" class="hidden">Masuk: <span class="font-semibold"></span></div>
                                    <div id="jamKeluarInfo" class="hidden">Keluar: <span class="font-semibold"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Actions -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- Primary Actions -->
                        <div
                            class="bg-white/95 backdrop-blur-md rounded-3xl p-6 shadow-2xl shadow-black/10 border border-white/20">
                            <h4 class="text-base font-poppins font-semibold text-gray-800 mb-4">Aksi Presensi</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Clock In Button -->
                                <button id="clockInBtn"
                                    class="group relative overflow-hidden bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-2xl p-6 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl hover:shadow-primary-500/25 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                    </div>
                                    <div class="relative flex items-center justify-center space-x-4">
                                        <div class="p-2 bg-white/20 rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <h3 class="text-base font-poppins font-semibold">Absen Masuk</h3>
                                            <p class="text-xs font-inter text-primary-100">Catat waktu kedatangan</p>
                                        </div>
                                    </div>
                                </button>

                                <!-- Clock Out Button -->
                                <button id="clockOutBtn"
                                    class="group relative overflow-hidden bg-gradient-to-r from-secondary-500 to-secondary-600 hover:from-secondary-600 hover:to-secondary-700 text-white rounded-2xl p-6 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl hover:shadow-secondary-500/25 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                    </div>
                                    <div class="relative flex items-center justify-center space-x-4">
                                        <div class="p-2 bg-white/20 rounded-xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <h3 class="text-base font-poppins font-semibold">Absen Keluar</h3>
                                            <p class="text-xs font-inter text-secondary-100">Catat waktu pulang</p>
                                        </div>
                                    </div>
                                </button>
                            </div>

                            <!-- Leave Request Button -->
                            <a href="{{ route('karyawan.izin.create') }}"
                                class="mt-4 w-full group relative overflow-hidden bg-gradient-to-r from-complimentary-500 to-complimentary-600 hover:from-complimentary-600 hover:to-complimentary-700 text-white rounded-2xl p-6 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl hover:shadow-complimentary-500/25 block">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                </div>
                                <div class="relative flex items-center justify-center space-x-4">
                                    <div class="p-2 bg-white/20 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <h3 class="text-base font-poppins font-semibold">Ajukan Izin</h3>
                                        <p class="text-xs font-inter text-complimentary-100">Buat permohonan izin</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Developer Tools -->
                        {{-- <div
                            class="bg-white/90 backdrop-blur-md rounded-2xl p-5 shadow-xl shadow-black/5 border border-white/20">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-poppins font-semibold text-gray-800">Developer Tools</h4>
                                <span class="text-[10px] px-2 py-1 rounded-full bg-gray-100 text-gray-600">Dev only</span>
                            </div>
                            <div class="space-y-3">
                                <!-- Test Location Button (Development Only) -->
                                <button id="testLocationBtn"
                                    class="w-full group relative overflow-hidden bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-xl p-3 transition-all duration-300 transform hover:scale-[1.01] hover:shadow-lg hover:shadow-gray-500/25">
                                    <div class="relative flex items-center justify-center space-x-3">
                                        <div class="p-1.5 bg-white/20 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <h3 class="text-sm font-poppins font-semibold">Test Lokasi</h3>
                                            <p class="text-xs font-inter text-gray-300">Simulasi lokasi kantor</p>
                                        </div>
                                    </div>
                                </button>

                                <!-- Real GPS Debug Button -->
                                <button id="debugGPSBtn"
                                    class="w-full group relative overflow-hidden bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl p-3 transition-all duration-300 transform hover:scale-[1.01] hover:shadow-lg hover:shadow-orange-500/25">
                                    <div class="relative flex items-center justify-center space-x-3">
                                        <div class="p-1.5 bg-white/20 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 14.5M9.75 18.637l2.25-2.236a2.25 2.25 0 000-3.2L9.75 11.033M21.25 14.5c.001-.246.001-.493.001-.74a24.301 24.301 0 00-4.5-.016M21.25 14.5l-2.69 1.126c-.955.4-1.787 1.002-2.559 1.874-.771.872-1.5 1.874-2.001 3M9.75 18.637c0 .246-.001.493-.001.74a24.301 24.301 0 004.5.016M9.75 18.637L12 20.873a2.25 2.25 0 003.2 0l2.236-2.236" />
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <h3 class="text-sm font-poppins font-semibold">Debug GPS</h3>
                                            <p class="text-xs font-inter text-orange-200">Lokasi browser real-time</p>
                                        </div>
                                    </div>
                                </button>

                                <!-- Test Connection Button -->
                                <button id="testConnectionBtn"
                                    class="w-full bg-purple-500 hover:bg-purple-600 text-white font-medium py-2.5 px-4 rounded-xl transition-colors">
                                    🔧 Test Connection
                                </button>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-sm mx-4">
            <div class="text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-500 mb-4"></div>
                <p class="text-gray-700 font-inter">Memproses lokasi...</p>
            </div>
        </div>
    </div>

    <!-- Alert Modal -->
    <div id="alertModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-sm mx-4 shadow-2xl">
            <div class="text-center">
                <div id="alertIcon" class="mx-auto mb-4 w-12 h-12 rounded-full flex items-center justify-center">
                    <!-- Icon will be added dynamically -->
                </div>
                <h3 id="alertTitle" class="text-lg font-poppins font-semibold text-gray-800 mb-2"></h3>
                <p id="alertMessage" class="text-sm font-inter text-gray-600 mb-4"></p>
                <button id="alertCloseBtn"
                    class="w-full bg-primary-500 hover:bg-primary-600 text-white font-medium py-2 px-4 rounded-xl transition-colors">
                    OK
                </button>
            </div>
        </div>
    </div>

    <!-- Camera Capture Modal -->
    <div id="cameraModal" class="hidden fixed inset-0 bg-black bg-opacity-70 items-center justify-center z-50 p-2">
        <div class="bg-white rounded-2xl p-3 sm:p-4 max-w-sm w-full shadow-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-sm sm:text-base font-poppins font-semibold text-gray-800 mb-2 sm:mb-3">Ambil Foto Bukti</h3>
            <div class="relative aspect-[4/3] w-full bg-black rounded-xl overflow-hidden mb-2 sm:mb-3">
                <video id="cameraVideo" autoplay playsinline class="w-full h-full object-cover"></video>
                <canvas id="cameraCanvas" class="hidden w-full h-full"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                <button id="captureBtn"
                    class="col-span-2 bg-primary-500 hover:bg-primary-600 text-white font-medium py-2 px-3 sm:py-2.5 sm:px-4 rounded-xl transition-colors text-sm">Ambil
                    Foto</button>
                <button id="retakeBtn"
                    class="hidden bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-3 sm:py-2.5 sm:px-4 rounded-xl transition-colors text-sm">Ulangi</button>
                <button id="usePhotoBtn"
                    class="hidden bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-3 sm:py-2.5 sm:px-4 rounded-xl transition-colors text-sm">Gunakan
                    Foto</button>
                <button id="cancelCameraBtn"
                    class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-3 sm:py-2.5 sm:px-4 rounded-xl transition-colors text-sm">Batal</button>
            </div>
        </div>
    </div>

    <script>
        let userLocation = null;
        let attendanceStatus = null;

        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            checkLocationPermission();
            loadAttendanceStatus();
        });

        // Check if geolocation is supported and get permission
        function checkLocationPermission() {
            if (!navigator.geolocation) {
                showAlert('error', 'Geolocation Error', 'Browser Anda tidak mendukung fitur lokasi.');
                return;
            }

            // Try to get location
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    userLocation = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        accuracy: position.coords.accuracy
                    };

                    console.log('📡 Initial GPS Reading:', userLocation);
                    updateLocationStatus('success', `Lokasi terdeteksi (±${Math.round(userLocation.accuracy)}m)`);
                },
                function(error) {
                    let message = 'Gagal mendapatkan lokasi';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            message = 'Akses lokasi ditolak. Mohon izinkan akses lokasi di browser.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            message = 'Timeout mendapatkan lokasi.';
                            break;
                    }
                    updateLocationStatus('error', message);
                }, {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0
                }
            );
        }

        // Load current attendance status
        function loadAttendanceStatus() {
            fetch('/absensi/status', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        attendanceStatus = data.data;
                        updateButtonStates();
                        updateStatusDisplay();

                        // Show location info if available
                        if (data.data.lokasi_penempatan) {
                            const locationInfo = document.getElementById('locationInfo');
                            const locationName = document.getElementById('locationName');
                            locationInfo.classList.remove('hidden');
                            locationName.textContent = data.data.lokasi_penempatan;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading status:', error);
                });
        }

        // Update button states based on attendance status and time
        function updateButtonStates() {
            const clockInBtn = document.getElementById('clockInBtn');
            const clockOutBtn = document.getElementById('clockOutBtn');

            // Clock In button logic
            if (attendanceStatus.has_clocked_in || (attendanceStatus.time_status && !attendanceStatus.time_status
                    .can_clock_in)) {
                clockInBtn.disabled = true;
                clockInBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                clockInBtn.disabled = false;
                clockInBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            let shouldDisableClockOut = false;

            if (attendanceStatus.has_clocked_out || !attendanceStatus.has_clocked_in) {
                shouldDisableClockOut = true;
            } else if (attendanceStatus.special_permissions && attendanceStatus.special_permissions.has_early_departure) {
                shouldDisableClockOut = true;
            } else if (attendanceStatus.time_status && !attendanceStatus.time_status.can_clock_out) {
                shouldDisableClockOut = true;
            }

            if (shouldDisableClockOut) {
                clockOutBtn.disabled = true;
                clockOutBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                clockOutBtn.disabled = false;
                clockOutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        // Update status display
        function updateStatusDisplay() {
            const statusContent = document.getElementById('statusContent');
            const attendanceInfo = document.getElementById('attendanceInfo');
            const jamMasukInfo = document.getElementById('jamMasukInfo');
            const jamKeluarInfo = document.getElementById('jamKeluarInfo');

            // Check for special permissions
            let hasSpecialPermissions = attendanceStatus.special_permissions &&
                (attendanceStatus.special_permissions.has_late_permission || attendanceStatus.special_permissions
                    .has_early_departure);

            // Display status based on work completion and time constraints
            if (attendanceStatus.has_clocked_out) {
                statusContent.innerHTML = `
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <p class="text-sm font-inter text-gray-600">Hari kerja selesai</p>
                `;
            } else if (attendanceStatus.has_clocked_in) {
                let workStatus = 'Sedang bekerja';

                // Check for early departure permission
                if (attendanceStatus.special_permissions && attendanceStatus.special_permissions.has_early_departure) {
                    workStatus =
                        `Sedang bekerja (Izin pulang awal jam ${attendanceStatus.special_permissions.early_departure_from})`;
                } else if (attendanceStatus.time_status && !attendanceStatus.time_status.can_clock_out) {
                    workStatus = `Sedang bekerja (Absen keluar: ${attendanceStatus.time_status.clock_out_start_time})`;
                }

                statusContent.innerHTML = `
                    <div class="w-3 h-3 bg-orange-500 rounded-full animate-pulse"></div>
                    <p class="text-sm font-inter text-gray-600">${workStatus}</p>
                `;
            } else {
                // Not clocked in yet
                let statusMessage = 'Siap untuk absensi';
                let statusColor = 'green';

                if (attendanceStatus.time_status) {
                    if (!attendanceStatus.time_status.can_clock_in) {
                        // Check if user has late permission
                        if (attendanceStatus.special_permissions && attendanceStatus.special_permissions
                            .has_late_permission) {
                            statusMessage =
                                `Izin terlambat sampai ${attendanceStatus.special_permissions.late_permission_until}`;
                            statusColor = 'yellow';
                        } else {
                            statusMessage =
                                `Waktu absen masuk telah berakhir (Max: ${attendanceStatus.time_status.clock_in_deadline})`;
                            statusColor = 'red';
                        }
                    } else {
                        if (attendanceStatus.special_permissions && attendanceStatus.special_permissions
                            .has_late_permission) {
                            statusMessage =
                                `Siap absen masuk (Izin terlambat sampai: ${attendanceStatus.special_permissions.late_permission_until})`;
                            statusColor = 'yellow';
                        } else {
                            statusMessage = `Siap absen masuk (Sampai: ${attendanceStatus.time_status.clock_in_deadline})`;
                            statusColor = 'green';
                        }
                    }
                }

                statusContent.innerHTML = `
                    <div class="w-3 h-3 bg-${statusColor}-500 rounded-full animate-pulse"></div>
                    <p class="text-sm font-inter text-gray-600">${statusMessage}</p>
                `;
            }

            // Show special permissions info
            if (hasSpecialPermissions) {
                const permissionInfo = document.createElement('div');
                permissionInfo.className = 'mt-2 p-2 bg-yellow-50 rounded-lg border border-yellow-200';

                let permissionText = '';
                if (attendanceStatus.special_permissions.has_late_permission) {
                    permissionText +=
                        `✅ Izin masuk terlambat sampai ${attendanceStatus.special_permissions.late_permission_until}<br>`;
                }
                if (attendanceStatus.special_permissions.has_early_departure) {
                    permissionText +=
                        `✅ Izin pulang awal jam ${attendanceStatus.special_permissions.early_departure_from} (Tidak perlu absen keluar)`;
                }

                permissionInfo.innerHTML = `
                    <div class="text-xs text-yellow-800">
                        <div class="font-semibold mb-1">Izin Khusus Hari Ini:</div>
                        <div>${permissionText}</div>
                    </div>
                `;
                statusContent.appendChild(permissionInfo);
            }

            // Show current time info if available
            if (attendanceStatus.time_status) {
                const timeInfo = document.createElement('div');
                timeInfo.className = 'mt-2 text-xs text-gray-500';
                timeInfo.innerHTML = `
                    <div>Waktu sekarang: <span class="font-semibold">${attendanceStatus.time_status.current_time}</span></div>
                    <div class="mt-1">${attendanceStatus.time_status.time_message}</div>
                `;
                statusContent.appendChild(timeInfo);
            }

            // Show attendance times if available
            if (attendanceStatus.jam_masuk || attendanceStatus.jam_keluar) {
                attendanceInfo.classList.remove('hidden');

                if (attendanceStatus.jam_masuk) {
                    jamMasukInfo.classList.remove('hidden');
                    jamMasukInfo.querySelector('span').textContent = attendanceStatus.jam_masuk;
                }

                if (attendanceStatus.jam_keluar) {
                    jamKeluarInfo.classList.remove('hidden');
                    jamKeluarInfo.querySelector('span').textContent = attendanceStatus.jam_keluar;
                }
            }
        }

        // Update location status in UI
        function updateLocationStatus(type, message) {
            const statusContent = document.getElementById('statusContent');

            if (type === 'success') {
                statusContent.innerHTML = `
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <p class="text-sm font-inter text-gray-600">${message}</p>
                `;
            } else {
                statusContent.innerHTML = `
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                    <p class="text-sm font-inter text-gray-600">${message}</p>
                `;
            }
        }

        // Clock in event
        document.getElementById('clockInBtn').addEventListener('click', function() {
            if (!userLocation) {
                showAlert('error', 'Lokasi Tidak Tersedia', 'Mohon pastikan GPS aktif dan izinkan akses lokasi.');
                return;
            }

            if (attendanceStatus.has_clocked_in) {
                showAlert('info', 'Sudah Absen', 'Anda sudah melakukan absen masuk hari ini.');
                return;
            }

            // Check time validity
            if (attendanceStatus.time_status && !attendanceStatus.time_status.can_clock_in) {
                showAlert('error', 'Waktu Absen Masuk Berakhir',
                    `Maaf, waktu absen masuk telah berakhir. Absen masuk hanya diperbolehkan sebelum jam ${attendanceStatus.time_status.clock_in_deadline} WIB.\n\nWaktu sekarang: ${attendanceStatus.time_status.current_time} WIB`
                );
                return;
            }

            openCameraFor('clock-in');
        });

        // Clock out event
        document.getElementById('clockOutBtn').addEventListener('click', function() {
            if (!userLocation) {
                showAlert('error', 'Lokasi Tidak Tersedia', 'Mohon pastikan GPS aktif dan izinkan akses lokasi.');
                return;
            }

            if (!attendanceStatus.has_clocked_in) {
                showAlert('error', 'Belum Absen Masuk', 'Anda harus melakukan absen masuk terlebih dahulu.');
                return;
            }

            if (attendanceStatus.has_clocked_out) {
                showAlert('info', 'Sudah Absen', 'Anda sudah melakukan absen keluar hari ini.');
                return;
            }

            // Check time validity
            if (attendanceStatus.time_status && !attendanceStatus.time_status.can_clock_out) {
                showAlert('error', 'Belum Waktunya Absen Keluar',
                    `Maaf, belum waktunya untuk absen keluar. Absen keluar hanya diperbolehkan setelah jam ${attendanceStatus.time_status.clock_out_start_time} WIB.\n\nWaktu sekarang: ${attendanceStatus.time_status.current_time} WIB`
                );
                return;
            }

            openCameraFor('clock-out');
        });

        // ===== Camera flow =====
        let mediaStream = null;
        let capturedPhotoDataUrl = null;
        let pendingAction = null; // 'clock-in' | 'clock-out'

        const cameraModal = document.getElementById('cameraModal');
        const cameraVideo = document.getElementById('cameraVideo');
        const cameraCanvas = document.getElementById('cameraCanvas');
        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const usePhotoBtn = document.getElementById('usePhotoBtn');
        const cancelCameraBtn = document.getElementById('cancelCameraBtn');

        function openCameraFor(action) {
            pendingAction = action;
            capturedPhotoDataUrl = null;
            cameraCanvas.classList.add('hidden');
            cameraVideo.classList.remove('hidden');
            captureBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
            usePhotoBtn.classList.add('hidden');
            cameraModal.classList.remove('hidden');
            cameraModal.classList.add('flex');
            startCamera();
        }

        function closeCamera() {
            stopCamera();
            cameraModal.classList.add('hidden');
            cameraModal.classList.remove('flex');
        }

        async function startCamera() {
            try {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    showAlert('error', 'Kamera tidak didukung', 'Browser Anda tidak mendukung kamera.');
                    return;
                }
                mediaStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user'
                    },
                    audio: false
                });
                cameraVideo.srcObject = mediaStream;
            } catch (e) {
                console.error('Camera error:', e);
                showAlert('error', 'Gagal membuka kamera', e.message || 'Periksa izin kamera di browser.');
                closeCamera();
            }
        }

        function stopCamera() {
            if (mediaStream) {
                mediaStream.getTracks().forEach(t => t.stop());
                mediaStream = null;
            }
            cameraVideo.srcObject = null;
        }

        function capturePhoto() {
            const videoWidth = cameraVideo.videoWidth;
            const videoHeight = cameraVideo.videoHeight;
            if (!videoWidth || !videoHeight) {
                showAlert('error', 'Kamera belum siap', 'Tunggu beberapa detik lalu coba lagi.');
                return;
            }
            cameraCanvas.width = videoWidth;
            cameraCanvas.height = videoHeight;
            const ctx = cameraCanvas.getContext('2d');
            ctx.drawImage(cameraVideo, 0, 0, videoWidth, videoHeight);
            capturedPhotoDataUrl = cameraCanvas.toDataURL('image/jpeg', 0.9);

            // Toggle preview state
            cameraVideo.classList.add('hidden');
            cameraCanvas.classList.remove('hidden');
            captureBtn.classList.add('hidden');
            retakeBtn.classList.remove('hidden');
            usePhotoBtn.classList.remove('hidden');
        }

        function retakePhoto() {
            capturedPhotoDataUrl = null;
            cameraCanvas.classList.add('hidden');
            cameraVideo.classList.remove('hidden');
            captureBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
            usePhotoBtn.classList.add('hidden');
        }

        function useCapturedPhoto() {
            if (!capturedPhotoDataUrl) {
                showAlert('error', 'Foto belum diambil', 'Silakan ambil foto terlebih dahulu.');
                return;
            }
            const action = pendingAction;
            closeCamera();
            performAttendanceWithPhoto(action, capturedPhotoDataUrl);
        }

        captureBtn.addEventListener('click', capturePhoto);
        retakeBtn.addEventListener('click', retakePhoto);
        usePhotoBtn.addEventListener('click', useCapturedPhoto);
        cancelCameraBtn.addEventListener('click', function() {
            closeCamera();
        });

        // Tambahkan fungsi debugging GPS
        function debugGPSLocation() {
            if (!navigator.geolocation) {
                console.log('Geolocation not supported');
                return;
            }

            // Get location dengan high accuracy
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const location = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        accuracy: position.coords.accuracy
                    };

                    console.log('🌍 GPS Location Debug:', location);
                    console.log('📍 Google Maps Link:',
                        `https://www.google.com/maps?q=${location.latitude},${location.longitude}`);

                    // Send to server for comparison
                    fetch('/debug-location', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(location)
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('🔍 Server Debug Response:', data);

                            if (data.distance_calculation) {
                                showAlert('info', 'Debug Info',
                                    `Jarak: ${data.distance_calculation.distance_meters}m\n` +
                                    `Radius: ${data.distance_calculation.allowed_radius}m\n` +
                                    `Valid: ${data.distance_calculation.is_valid ? 'Ya' : 'Tidak'}\n` +
                                    `Akurasi GPS: ${location.accuracy}m`
                                );
                            }
                        });
                },
                function(error) {
                    console.error('GPS Error:', error);
                }, {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0 // Force fresh reading
                }
            );
        }

        // Update tombol test lokasi untuk set koordinat manual (optional dev tools)
        const testLocationBtn = document.getElementById('testLocationBtn');
        if (testLocationBtn) {
            testLocationBtn.addEventListener('click', function() {
                // Set location to Stasiun Doplang coordinates for testing
                userLocation = {
                    latitude: -7.18290000,
                    longitude: 111.28796000
                };

                showAlert('info', 'Test Lokasi',
                    'Lokasi diset ke Stasiun Doplang untuk testing.\n\nCoordinates: -7.18290000, 111.28796000');
                updateLocationStatus('success', 'Test lokasi: Stasiun Doplang');
            });
        }

        // Debug GPS Button - Real GPS location debugging (optional dev tools)
        const debugGPSBtn = document.getElementById('debugGPSBtn');
        if (debugGPSBtn) {
            debugGPSBtn.addEventListener('click', function() {
                debugRealGPSLocation();
            });
        }

        // Test Connection Function (optional dev tools)
        const testConnectionBtn = document.getElementById('testConnectionBtn');
        if (testConnectionBtn) {
            testConnectionBtn.addEventListener('click', function() {
                console.log('🔧 Testing connection...');

                fetch('/test-absensi', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        }
                    })
                    .then(response => {
                        console.log('Test response status:', response.status);
                        console.log('Test response headers:', [...response.headers.entries()]);

                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            return response.json();
                        } else {
                            return response.text();
                        }
                    })
                    .then(data => {
                        console.log('✅ Connection test result:', data);
                        alert('Connection test: ' + JSON.stringify(data));
                    })
                    .catch(error => {
                        console.error('❌ Connection test error:', error);
                        alert('Connection error: ' + error.message);
                    });
            });
        }

        // Function untuk debug GPS real-time
        function debugRealGPSLocation() {
            if (!navigator.geolocation) {
                showAlert('error', 'GPS Error', 'Browser Anda tidak mendukung geolocation.');
                return;
            }

            showLoading(true);
            console.log('🔍 Starting Real GPS debug...');

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    console.log('📍 GPS Position Object:', position);

                    const location = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        accuracy: position.coords.accuracy,
                        timestamp: new Date(position.timestamp).toISOString()
                    };

                    console.log('🌍 Parsed Location:', location);
                    console.log(
                        `📱 Google Maps Link: https://www.google.com/maps?q=${location.latitude},${location.longitude}`
                    );

                    // Update user location dengan GPS real
                    userLocation = location;

                    // Send to server for detailed debugging
                    fetch('/debug-location', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(location)
                        })
                        .then(response => response.json())
                        .then(data => {
                            showLoading(false);
                            console.log('🔍 Server Debug Response:', data);

                            let debugMessage = 'DEBUG INFO GPS:\n\n';
                            debugMessage += `📍 Your Location:\n`;
                            debugMessage += `   Lat: ${location.latitude}\n`;
                            debugMessage += `   Lon: ${location.longitude}\n`;
                            debugMessage += `   Accuracy: ±${Math.round(location.accuracy)}m\n\n`;

                            if (data.lokasi_penempatan) {
                                debugMessage += `🏢 Office Location:\n`;
                                debugMessage += `   Name: ${data.lokasi_penempatan.nama_lokasi}\n`;
                                debugMessage += `   Lat: ${data.lokasi_penempatan.latitude}\n`;
                                debugMessage += `   Lon: ${data.lokasi_penempatan.longitude}\n`;
                                debugMessage += `   Radius: ${data.lokasi_penempatan.radius}m\n\n`;
                            }

                            if (data.distance_calculation) {
                                debugMessage += `📏 Distance Calculation:\n`;
                                debugMessage += `   Distance: ${data.distance_calculation.distance_meters}m\n`;
                                debugMessage += `   Allowed: ${data.distance_calculation.allowed_radius}m\n`;
                                debugMessage +=
                                    `   Status: ${data.distance_calculation.is_valid ? '✅ VALID' : '❌ TOO FAR'}\n\n`;

                                debugMessage += `🔗 Check locations:\n`;
                                debugMessage += `Your: ${data.distance_calculation.google_maps_link}\n`;
                                debugMessage += `Office: ${data.distance_calculation.office_maps_link}`;
                            }

                            showAlert('info', 'GPS Debug Results', debugMessage);
                            updateLocationStatus('success', `GPS Real: ±${Math.round(location.accuracy)}m`);
                        })
                        .catch(error => {
                            showLoading(false);
                            console.error('❌ Server Error:', error);
                            showAlert('error', 'Server Error', 'Failed to get debug info: ' + error.message);
                        });
                },
                function(error) {
                    showLoading(false);
                    console.error('❌ GPS Error:', error);

                    let errorMessage = 'GPS Error: ';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage += 'Permission denied. Allow location access.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage += 'Position unavailable. Check GPS.';
                            break;
                        case error.TIMEOUT:
                            errorMessage += 'Request timeout. Try again.';
                            break;
                        default:
                            errorMessage += 'Unknown error.';
                    }

                    showAlert('error', 'GPS Error', errorMessage);
                }, {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0 // Force fresh reading
                }
            );
        }

        // Perform attendance action with photo capture
        function performAttendanceWithPhoto(action, photoDataUrl) {
            showLoading(true);

            // First check location validity
            fetch('/absensi/check-location', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(userLocation)
                })
                .then(response => {
                    console.log('Location check response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Location check response:', data); // Debug log

                    if (data.success) {
                        // Location is valid, proceed with attendance
                        return fetch(`/absensi/${action}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                latitude: userLocation.latitude,
                                longitude: userLocation.longitude,
                                photo: photoDataUrl
                            })
                        });
                    } else {
                        // Location is invalid, show detailed error
                        let errorMessage = data.message;
                        if (data.distance_info) {
                            errorMessage += `\n\nJarak: ${data.distance_info.distance} ${data.distance_info.unit}`;
                            errorMessage += `\nRadius yang diizinkan: ${data.distance_info.allowed_radius} meter`;
                        }
                        if (data.debug) {
                            console.log('Debug info:', data.debug);
                            errorMessage += '\n\nInfo Debug:\n';
                            errorMessage +=
                                `Lokasi Anda: ${data.debug.user_location[0]}, ${data.debug.user_location[1]}\n`;
                            errorMessage +=
                                `Lokasi Kantor: ${data.debug.office_location[0]}, ${data.debug.office_location[1]}\n`;
                            errorMessage += `Jarak: ${data.debug.distance}m dari ${data.debug.radius}m`;
                        }
                        throw new Error(errorMessage);
                    }
                })
                .then(response => {
                    console.log('Attendance response status:', response.status);
                    console.log('Attendance response headers:', response.headers.get('content-type'));

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }

                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Server tidak mengembalikan JSON response. Mungkin ada error atau redirect.');
                    }

                    return response.json();
                })
                .then(data => {
                    showLoading(false);
                    console.log('Attendance response data:', data);

                    if (data.success) {
                        showAlert('success', 'Berhasil!', data.message);
                        // Reload attendance status
                        loadAttendanceStatus();
                    } else {
                        showAlert('error', 'Gagal', data.message);
                    }
                })
                .catch(error => {
                    showLoading(false);
                    showAlert('error', 'Error', error.message || 'Terjadi kesalahan saat memproses absensi.');
                });
        } // Show/hide loading modal
        function showLoading(show) {
            const modal = document.getElementById('loadingModal');
            if (show) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Show alert modal
        function showAlert(type, title, message) {
            const modal = document.getElementById('alertModal');
            const icon = document.getElementById('alertIcon');
            const titleEl = document.getElementById('alertTitle');
            const messageEl = document.getElementById('alertMessage');

            // Set icon based on type
            let iconHtml = '';
            let iconClass = '';

            switch (type) {
                case 'success':
                    iconClass = 'bg-green-100';
                    iconHtml =
                        '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    break;
                case 'error':
                    iconClass = 'bg-red-100';
                    iconHtml =
                        '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    break;
                case 'info':
                    iconClass = 'bg-blue-100';
                    iconHtml =
                        '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                    break;
            }

            icon.className = `mx-auto mb-4 w-12 h-12 rounded-full flex items-center justify-center ${iconClass}`;
            icon.innerHTML = iconHtml;
            titleEl.textContent = title;
            messageEl.textContent = message;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Close alert modal
        document.getElementById('alertCloseBtn').addEventListener('click', function() {
            const modal = document.getElementById('alertModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        // Close modal when clicking outside
        document.getElementById('alertModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.classList.remove('flex');
            }
        });
    </script>
@endsection
