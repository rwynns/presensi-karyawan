<nav class="bg-gradient-to-r from-primary-600 to-primary-700 shadow-lg border-b border-primary-800/20 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left side - User name -->
            <div class="flex items-center">
                @auth
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-complimentary-500 to-complimentary-600 rounded-xl flex items-center justify-center shadow-md ring-2 ring-white/20">
                            <span class="text-sm font-semibold text-white font-inter">
                                {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white font-inter">{{ Auth::user()->nama }}</p>
                            <p class="text-xs text-primary-100 font-poppins">{{ Auth::user()->role->nama_role ?? 'User' }}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="text-xl font-bold text-white font-inter tracking-wide">
                        <span
                            class="bg-gradient-to-r from-white to-primary-100 bg-clip-text text-transparent">Presensi</span>
                        <span class="text-complimentary-300 ml-1">Karyawan</span>
                    </div>
                @endauth
            </div>

            <!-- Right side - Menu items -->
            <div class="hidden md:flex items-center space-x-2">
                @auth
                    <!-- Profile Menu -->
                    <a href="{{ route('profile.index') }}"
                        class="group inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl text-white/90 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 ease-in-out">
                        <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-poppins">Profile</span>
                    </a>

                    <!-- Riwayat Absen Menu -->
                    @if (Auth::user()->role_id == 2)
                        <a href="{{ route('karyawan.riwayat.index') }}"
                            class="group inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl text-white/90 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 ease-in-out">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-poppins">Riwayat Absen</span>
                        </a>
                    @elseif(Auth::user()->role_id == 1)
                        <a href="{{ route('admin.absensi.index') }}"
                            class="group inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl text-white/90 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200 ease-in-out">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <span class="font-poppins">Data Absensi</span>
                        </a>
                    @endif

                    <!-- Logout Menu -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="group inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl bg-gradient-to-r from-complimentary-500 to-complimentary-600 text-white hover:from-complimentary-600 hover:to-complimentary-700 focus:outline-none focus:ring-2 focus:ring-complimentary-400 shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 ease-in-out">
                            <svg class="w-4 h-4 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span class="font-poppins font-semibold">Logout</span>
                        </button>
                    </form>
                @else
                    <!-- Guest state -->
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-6 py-2 text-sm font-semibold rounded-xl bg-gradient-to-r from-complimentary-500 to-complimentary-600 text-white hover:from-complimentary-600 hover:to-complimentary-700 focus:outline-none focus:ring-2 focus:ring-complimentary-400 shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 ease-in-out font-poppins">
                        Login
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobileMenuToggle"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-200">
                    <svg class="h-6 w-6 transition-transform duration-200" stroke="currentColor" fill="none"
                        viewBox="0 0 24 24">
                        <path id="menu-open" class="block" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="menu-close" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="md:hidden hidden border-t border-primary-800/20">
        <div class="px-4 pt-4 pb-6 space-y-3 bg-gradient-to-b from-primary-700 to-primary-800">
            @auth
                <!-- Mobile User Info -->
                <div class="px-3 py-4 border-b border-primary-600/30">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-complimentary-500 to-complimentary-600 rounded-xl flex items-center justify-center shadow-md ring-2 ring-white/20">
                            <span class="text-base font-semibold text-white font-inter">
                                {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-base font-semibold text-white font-inter">{{ Auth::user()->nama }}</p>
                            <p class="text-sm text-primary-100 font-poppins">{{ Auth::user()->role->nama_role ?? 'User' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Items -->
                <div class="space-y-2">
                    <a href="{{ route('profile.index') }}"
                        class="group flex items-center px-4 py-3 text-base font-medium text-white/90 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 font-poppins">
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>

                    @if (Auth::user()->role_id == 2)
                        <a href="{{ route('karyawan.riwayat.index') }}"
                            class="group flex items-center px-4 py-3 text-base font-medium text-white/90 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 font-poppins">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Riwayat Absen
                        </a>
                    @elseif(Auth::user()->role_id == 1)
                        <a href="{{ route('admin.absensi.index') }}"
                            class="group flex items-center px-4 py-3 text-base font-medium text-white/90 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 font-poppins">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Data Absensi
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit"
                            class="group w-full flex items-center px-4 py-3 text-base font-semibold bg-gradient-to-r from-complimentary-500 to-complimentary-600 text-white hover:from-complimentary-600 hover:to-complimentary-700 rounded-xl transition-all duration-200 shadow-md font-poppins">
                            <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="block px-4 py-3 text-base font-semibold bg-gradient-to-r from-complimentary-500 to-complimentary-600 text-white hover:from-complimentary-600 hover:to-complimentary-700 rounded-xl transition-all duration-200 text-center shadow-md font-poppins">
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuOpen = document.getElementById('menu-open');
        const menuClose = document.getElementById('menu-close');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                menuOpen.classList.toggle('hidden');
                menuClose.classList.toggle('hidden');

                // Add smooth rotation animation to hamburger icon
                if (mobileMenu.classList.contains('hidden')) {
                    mobileMenuToggle.querySelector('svg').style.transform = 'rotate(0deg)';
                } else {
                    mobileMenuToggle.querySelector('svg').style.transform = 'rotate(180deg)';
                }
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                    menuOpen.classList.remove('hidden');
                    menuClose.classList.add('hidden');
                    mobileMenuToggle.querySelector('svg').style.transform = 'rotate(0deg)';
                }
            });
        }
    });
</script>
