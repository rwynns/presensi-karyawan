<nav class="bg-white/90 shadow-lg py-4 px-6 fixed top-0 left-0 right-0 z-50 rounded-b-4xl">
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <div class="hidden md:flex items-center space-x-2">
                <p class="font-inter font-bold text-xl">Erwin Saputro</p>
            </div>

            <div class="hidden md:flex items-center">
                @auth
                    <div class="relative">
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 z-10">
                            <a href=""
                                class="block px-4 py-2 text-sm text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60]/10 rounded-lg mx-1 my-1 font-poppins">Profil</a>

                            @if (Auth::user()->isAdmin())
                                <!-- Admin menu items -->
                                <a href=""
                                    class="block px-4 py-2 text-sm text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60]/10 rounded-lg mx-1 my-1 font-poppins">Dashboard</a>
                            @elseif(Auth::user()->isTukang())
                                <!-- Tukang menu items -->
                                <a href=""
                                    class="block px-4 py-2 text-sm text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60]/10 rounded-lg mx-1 my-1 font-poppins">Dashboard</a>
                            @endif

                            <!-- Customer Orders - visible to all users -->
                            <a href=""
                                class="block px-4 py-2 text-sm text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60]/10 rounded-lg mx-1 my-1 font-poppins">
                                Pesanan Saya
                            </a>

                            <form method="POST" action="">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60]/10 rounded-lg mx-1 my-1 font-poppins">
                                    Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login"
                        class="text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-6 py-2 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Masuk</a>
                @endauth
            </div>

            <div class="md:hidden flex items-center">
                <button id="mobileMenuButton"
                    class="outline-none mobile-menu-button p-2 hover:bg-[#332E60]/10 rounded-xl transition-all">
                    <svg class="w-6 h-6 text-[#2A2C65] hover:text-[#F4C542]" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu with rounded bottom -->
    <div class="hidden mobile-menu md:hidden rounded-b-3xl overflow-hidden">
        <ul class="mt-4 pb-3 space-y-1 px-4">
            <!-- Add cart link at the top of mobile menu -->
            <li>
                @auth
                    <button id="mobileCartButton"
                        class="flex w-full items-center text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Keranjang <span id="mobileCartCount"
                            class="ml-1 bg-[#F4C542] text-[#332E60] rounded-full h-5 w-5 inline-flex items-center justify-center text-xs font-bold">0</span>
                    </button>
                @else
                    <a href=""
                        class="flex w-full items-center text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Login untuk Keranjang
                    </a>
                @endauth
            </li>
            <li>
                <a href="/"
                    class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                    Beranda
                </a>
            </li>
            <li>
                <a href="/#tentang-kami"
                    class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase scroll-smooth">
                    Tentang Kami
                </a>
            </li>
            <li>
                <a href="/#layanan"
                    class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase scroll-smooth">
                    Layanan
                </a>
            </li>
            <li>
                <a href="/#kontak"
                    class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase scroll-smooth">
                    Kontak
                </a>
            </li>
            <div class="border-t border-gray-200 my-3"></div>
            @auth
                <li>
                    <a href=""
                        class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                        Profil
                    </a>
                </li>
                @if (Auth::user()->isAdmin())
                    <!-- Admin mobile menu item -->
                    <li>
                        <a href=""
                            class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                            Dashboard
                        </a>
                    </li>
                @elseif(Auth::user()->isTukang())
                    <!-- Tukang mobile menu item -->
                    <li>
                        <a href=""
                            class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                            Dashboard
                        </a>
                    </li>
                @endif
                <!-- Pesanan Saya link for all users -->
                <li>
                    <a href=""
                        class="block text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                        Pesanan Saya
                    </a>
                </li>
                <li>
                    <form method="POST" action="">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left text-[#2A2C65] hover:text-[#F4C542] hover:bg-[#332E60] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                            Keluar
                        </button>
                    </form>
                </li>
            @else
                <li>
                    <a href=""
                        class="block text-white bg-[#332E60] hover:bg-[#1D1B37] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase mb-2">
                        Masuk
                    </a>
                </li>
                <li class="mb-2">
                    <a href=""
                        class="block text-[#332E60] border border-[#332E60] hover:bg-[#332E60] hover:text-[#F4C542] px-4 py-3 rounded-xl transition-all font-poppins font-semibold text-[15px] uppercase">
                        Daftar
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</nav>
