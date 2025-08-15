@extends('layouts.dashboard')

@section('title', 'Manajemen Jabatan')

@section('content')
    <div class="flex-1 overflow-y-auto p-4">
        <div class="py-4">
            <div class="flex justify-between items-center">
                <h1 class="font-bold text-2xl text-gray-900">Manajemen Jabatan</h1>
                <a href="{{ route('admin.jabatan.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg>
                    Tambah Jabatan
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm ring-1 ring-gray-900/5 p-4 mb-4">
            <form method="GET" action="{{ route('admin.jabatan.index') }}" id="filterForm"
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Cari nama jabatan atau kode jabatan..." autocomplete="off">
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Cari
                    </button>
                    <a href="{{ route('admin.jabatan.index') }}"
                        class="border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Main Data Table -->
        <div id="jabatan-table-container" class="bg-white rounded-lg shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
            @include('admin.jabatan.partials.table')
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Real-time Search with AJAX
            let searchTimeout;
            const searchInput = document.querySelector('input[name="search"]');
            const tableContainer = document.getElementById('jabatan-table-container');
            const originalContent = tableContainer.innerHTML;

            // Configure Axios with CSRF token
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const searchQuery = this.value.trim();

                    searchTimeout = setTimeout(async () => {
                        await performSearch(searchQuery);
                    }, 500);
                });

                // Clear search when focus and input is empty
                searchInput.addEventListener('focus', function() {
                    if (this.value === '') {
                        this.select();
                    }
                });
            }

            async function performSearch(query) {
                try {
                    // Show loading state
                    showLoadingState();

                    // Make AJAX request
                    const response = await axios.get('{{ route('admin.jabatan.index') }}', {
                        params: {
                            search: query,
                            ajax: 1
                        },
                        timeout: 10000
                    });

                    // Update table content
                    if (response.data && response.data.html) {
                        tableContainer.innerHTML = response.data.html;

                        // Re-bind delete buttons
                        bindDeleteButtons();

                        // Update URL without refresh
                        const url = new URL(window.location);
                        if (query) {
                            url.searchParams.set('search', query);
                        } else {
                            url.searchParams.delete('search');
                        }
                        window.history.replaceState({}, '', url);

                    }
                } catch (error) {
                    console.error('Search error:', error);

                    // Show error message
                    Swal.fire({
                        title: 'Pencarian Gagal',
                        text: 'Terjadi kesalahan saat melakukan pencarian. Silakan coba lagi.',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });

                    // Restore original content on error
                    tableContainer.innerHTML = originalContent;
                    bindDeleteButtons();
                }
            }

            function showLoadingState() {
                const loadingHtml = `
                    <div class="bg-blue-600 px-4 py-3">
                        <div class="flex items-center justify-between">
                            <h2 class="text-white font-semibold">Daftar Jabatan</h2>
                            <div class="text-white text-sm">
                                <span class="bg-white/20 px-2 py-1 rounded">Mencari...</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-8 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 text-blue-500 animate-spin mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <p class="text-gray-500">Mencari jabatan...</p>
                        </div>
                    </div>
                `;
                tableContainer.innerHTML = loadingHtml;
            }

            function bindDeleteButtons() {
                // SweetAlert Delete Confirmation
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const namaJabatan = this.getAttribute('data-nama');
                        const form = this.closest('.delete-form');

                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            html: `Apakah Anda yakin ingin menghapus jabatan <strong>"${namaJabatan}"</strong>?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            focusCancel: true,
                            customClass: {
                                popup: 'swal2-popup-custom',
                                title: 'swal2-title-custom',
                                confirmButton: 'swal2-confirm-custom',
                                cancelButton: 'swal2-cancel-custom'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Show loading
                                Swal.fire({
                                    title: 'Menghapus...',
                                    html: 'Mohon tunggu sebentar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    willOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                // Submit form
                                form.submit();
                            }
                        });
                    });
                });

                // Bind pagination links
                document.querySelectorAll('.pagination-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('data-url') || this.href;

                        if (!url) return;

                        // Add loading class to table
                        tableContainer.classList.add('table-loading');

                        // Extract page number from URL
                        const urlObj = new URL(url, window.location.origin);
                        const searchParams = new URLSearchParams(urlObj.search);

                        // Add current search query
                        const currentSearch = searchInput.value.trim();
                        if (currentSearch) {
                            searchParams.set('search', currentSearch);
                        }

                        // Add AJAX parameter
                        searchParams.set('ajax', '1');

                        // Make AJAX request for pagination
                        performSearchWithUrl(urlObj.pathname + '?' + searchParams.toString());
                    });
                });
            }

            async function performSearchWithUrl(url) {
                try {
                    showLoadingState();

                    const response = await axios.get(url, {
                        timeout: 10000
                    });

                    if (response.data && response.data.html) {
                        tableContainer.innerHTML = response.data.html;
                        tableContainer.classList.remove('table-loading');
                        bindDeleteButtons();

                        // Clean up URL for history
                        const cleanUrl = url.replace('&ajax=1', '').replace('?ajax=1&', '?').replace('?ajax=1',
                            '');
                        window.history.replaceState({}, '', cleanUrl);

                        // Smooth scroll to top of table
                        tableContainer.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start',
                            inline: 'nearest'
                        });
                    }
                } catch (error) {
                    console.error('Pagination error:', error);
                    tableContainer.classList.remove('table-loading');

                    Swal.fire({
                        title: 'Gagal Memuat Halaman',
                        text: 'Terjadi kesalahan saat memuat halaman. Silakan coba lagi.',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });

                    // Restore original content on error
                    tableContainer.innerHTML = originalContent;
                    bindDeleteButtons();
                }
            }

            // Initial binding
            bindDeleteButtons();

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });

            // Enhanced form interactions for manual submit
            const submitButton = document.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.addEventListener('click', function(e) {
                    // Only trigger if it's a manual form submission
                    if (searchInput.value.trim() !== '') {
                        e.preventDefault();
                        performSearch(searchInput.value.trim());
                    }
                });
            }

            // Handle reset button
            const resetButton = document.querySelector('a[href*="jabatan.index"]');
            if (resetButton) {
                resetButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    searchInput.value = '';
                    performSearch('');
                });
            }
        });

        // Show success message if redirected after delete
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timerProgressBar: true
            });
        @endif

        // Show error message if any
        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                timer: 5000,
                showConfirmButton: true,
                toast: true,
                position: 'top-end',
                timerProgressBar: true
            });
        @endif
    </script>

    <style>
        .swal2-popup-custom {
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .swal2-title-custom {
            color: #374151;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .swal2-confirm-custom {
            background-color: #dc2626 !important;
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
        }

        .swal2-cancel-custom {
            background-color: #6b7280 !important;
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
        }

        .swal2-confirm-custom:hover {
            background-color: #b91c1c !important;
        }

        .swal2-cancel-custom:hover {
            background-color: #4b5563 !important;
        }

        /* Loading animation for search input */
        input[name="search"]:disabled {
            background-color: #f3f4f6;
            cursor: wait;
        }

        /* Smooth transitions */
        .transition-opacity {
            transition: opacity 0.3s ease-in-out;
        }

        /* Pagination improvements */
        .pagination-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .pagination-link:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pagination-link:active {
            transform: translateY(0);
        }

        /* Better spacing for mobile pagination */
        @media (max-width: 640px) {
            .pagination-link {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
        }

        /* Loading state for table */
        .table-loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .table-loading * {
            cursor: wait !important;
        }
    </style>
@endpush
