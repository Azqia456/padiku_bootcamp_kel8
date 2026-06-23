<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dinas Pertanian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --hijau-utama: #0A5C34;
            --hijau-sekunder: #2E7D32;
            --hijau-muda: #63A52F;
            --hijau-highlight: #8BC34A;
            --emas-tua: #D9A21B;
            --emas-utama: #F2C230;
            --emas-terang: #FFD54F;
            --abu-teknologi: #6E6E6E;
            --putih: #FFFFFF;
        }
        .bg-hijau-utama { background-color: var(--hijau-utama); }
        .bg-hijau-sekunder { background-color: var(--hijau-sekunder); }
        .bg-hijau-muda { background-color: var(--hijau-muda); }
        .bg-emas-utama { background-color: var(--emas-utama); }
        .text-hijau-utama { color: var(--hijau-utama); }
        .text-emas-utama { color: var(--emas-utama); }
        .border-hijau-utama { border-color: var(--hijau-utama); }
        .sidebar-link:hover { background-color: rgba(242, 194, 48, 0.1); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar (Left) -->
        <aside id="sidebar" class="w-56 bg-hijau-utama text-white p-6 transition-all duration-300 ease-in-out">
            <div class="flex items-center mb-8">
                <button id="sidebarToggle" class="p-2 rounded-lg hover:bg-white/10 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="sidebar-link block px-4 py-3 rounded-lg hover:bg-white/10 transition flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="sidebar-text">Dashboard Utama</span>
                </a>
                <a href="#" class="sidebar-link block px-4 py-3 rounded-lg hover:bg-white/10 transition flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="sidebar-text">Manajemen Petani</span>
                </a>
                <a href="{{ route('dashboard.map') }}" class="sidebar-link block px-4 py-3 rounded-lg hover:bg-white/10 transition flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <span class="sidebar-text">Monitoring Lahan</span>
                </a>
                <a href="#" class="sidebar-link block px-4 py-3 rounded-lg hover:bg-white/10 transition flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="sidebar-text">Monitoring Tanam</span>
                </a>
                <a href="#" class="sidebar-link block px-4 py-3 rounded-lg hover:bg-white/10 transition flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span class="sidebar-text">Monitoring Hama</span>
                </a>
                <a href="#" class="sidebar-link block px-4 py-3 rounded-lg hover:bg-white/10 transition flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    <span class="sidebar-text">Distribusi Pupuk</span>
                </a>
                <a href="{{ route('dashboard.food-balance') }}" class="sidebar-link block px-4 py-3 rounded-lg hover:bg-white/10 transition flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="sidebar-text">Neraca Pangan</span>
                </a>
                <a href="#" class="sidebar-link block px-4 py-3 rounded-lg hover:bg-white/10 transition flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="sidebar-text">Early Warning</span>
                </a>
            </nav>

            <div class="border-t border-green-700 pt-6 mt-8">
                <h3 class="text-lg font-bold mb-4 sidebar-text">Informasi</h3>
                <div class="space-y-4">
                    <div class="bg-white/10 rounded-lg p-4">
                        <p class="text-sm text-green-200 sidebar-text">Total Data</p>
                        <p class="text-2xl font-bold">{{ $totalPlantings }}</p>
                        <p class="text-xs text-green-300 sidebar-text">Lahan terdaftar</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-4">
                        <p class="text-sm text-green-200 sidebar-text">Status Sistem</p>
                        <p class="text-sm font-bold text-emas-utama">Online</p>
                        <p class="text-xs text-green-300 sidebar-text">Terakhir update: {{ now()->format('H:i') }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-hijau-utama text-white shadow-lg">
                <div class="container mx-auto px-4 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Search -->
                        <div class="flex-1 max-w-md">
                            <div class="relative">
                                <input type="text" placeholder="Cari..." class="w-full px-4 py-2 rounded-full bg-white/20 text-white placeholder-green-200 focus:outline-none focus:ring-2 focus:ring-emas-utama">
                                <svg class="absolute right-3 top-2.5 h-5 w-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Right Section -->
                        <div class="flex items-center space-x-4">
                            <!-- Notification Bell -->
                            <button class="relative p-2 rounded-full hover:bg-white/10 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-emas-utama rounded-full"></span>
                            </button>

                            <!-- Profile -->
                            @auth
                                <div class="flex items-center space-x-2">
                                    <div class="hidden md:block text-right">
                                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-green-200">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="w-8 h-8 bg-emas-utama rounded-full flex items-center justify-center">
                                        <span class="text-hijau-utama font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                </div>
                            @endauth

                            <!-- Organization Info (replaces PADIKU logo) -->
                            @auth
                                <div class="flex items-center space-x-2">
                                    <div class="text-right">
                                        <h1 class="text-lg font-bold">Dinas Pertanian</h1>
                                        <p class="text-xs text-green-200">{{ Auth::user()->name }}</p>
                                    </div>
                                    <div class="w-10 h-10 bg-emas-utama rounded-full flex items-center justify-center">
                                        <span class="text-hijau-utama font-bold text-lg">D</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <div class="text-right">
                                        <h1 class="text-lg font-bold">Dinas Pertanian</h1>
                                    </div>
                                    <div class="w-10 h-10 bg-emas-utama rounded-full flex items-center justify-center">
                                        <span class="text-hijau-utama font-bold text-lg">D</span>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6">
                <!-- Hero Section -->
                <section class="bg-gradient-to-r from-[#0A5C34] to-[#2E7D32] text-white rounded-xl p-8 mb-8">
                    <div class="max-w-3xl">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Kelola Tanam, Panen Lebih Pasti</h2>
                        <p class="text-lg text-green-100 mb-6">Platform Digital Informasi dan Koordinasi Usaha Tani hadir untuk membantu petani Karawang merencanakan tanam, berbagi ilmu, dan berkoordinasi untuk hasil panen yang optimal.</p>
                        <button class="bg-emas-utama text-hijau-utama font-bold py-3 px-6 rounded-full hover:bg-emas-terang transition">
                            Mulai Sekarang
                        </button>
                    </div>
                </section>

                <!-- Statistics Cards -->
                <section class="mb-8">
                    <h3 class="text-xl font-bold text-hijau-utama mb-6">Dashboard Utama</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-hijau-utama">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-hijau-utama" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-xs">Total Sawah</p>
                                <p class="text-xl font-bold text-hijau-utama">{{ number_format($totalArea, 2) }} Ha</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-emas-utama">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-emas-utama" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10L4 17"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-xs">Total Produksi</p>
                                <p class="text-xl font-bold text-hijau-utama">{{ number_format($totalArea * 5, 0) }} ton</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-hijau-sekunder">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-hijau-sekunder" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-xs">Prediksi Produksi</p>
                                <p class="text-xl font-bold text-hijau-utama">{{ number_format($totalArea * 5.2, 0) }} ton</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-hijau-muda">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-hijau-muda" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-xs">Total Petani</p>
                                <p class="text-xl font-bold text-hijau-utama">{{ $totalFarmers }}</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-emas-tua">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-emas-tua" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-xs">Luas LP2B</p>
                                <p class="text-xl font-bold text-hijau-utama">{{ number_format($totalArea * 0.8, 2) }} Ha</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-emas-terang">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-emas-terang" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-xs">Surplus Pangan</p>
                                <p class="text-xl font-bold text-hijau-utama">{{ number_format($totalArea * 5 - $totalFarmers * 0.3, 0) }} ton</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Quick Actions -->
                <section class="mb-8">
                    <h3 class="text-xl font-bold text-hijau-utama mb-6">Akses Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('dashboard.map') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition border-t-4 border-hijau-utama">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-hijau-utama" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-hijau-utama">Peta Pertanian</p>
                                    <p class="text-sm text-gray-500">Lihat sebaran lahan</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('dashboard.statistics') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition border-t-4 border-hijau-sekunder">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-hijau-sekunder" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-hijau-utama">Statistik Produksi</p>
                                    <p class="text-sm text-gray-500">Data produksi padi</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('dashboard.food-balance') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition border-t-4 border-emas-utama">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-emas-utama" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-hijau-utama">Neraca Pangan</p>
                                    <p class="text-sm text-gray-500">Keseimbangan pangan</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('dashboard.data-analysis') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition border-t-4 border-hijau-muda">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-hijau-muda" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-hijau-utama">Analisis Data</p>
                                    <p class="text-sm text-gray-500">Analisis mendalam</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </section>

                <!-- Empty State -->
                @if($totalPlantings == 0)
                <section class="mb-8">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada data</h3>
                        <p class="text-gray-600">Database masih kosong. Silakan tambahkan data melalui API atau mobile app.</p>
                    </div>
                </section>
                @endif
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        let isExpanded = true;

        sidebarToggle.addEventListener('click', () => {
            isExpanded = !isExpanded;
            if (isExpanded) {
                // Back to normal (icons + text)
                sidebar.classList.remove('w-16');
                sidebar.classList.remove('p-2');
                sidebar.classList.add('w-56');
                sidebar.classList.add('p-6');
                document.querySelectorAll('.sidebar-text').forEach(el => {
                    el.classList.remove('hidden');
                });
                document.querySelectorAll('.sidebar-link').forEach(el => {
                    el.classList.remove('justify-center');
                    el.classList.add('justify-start');
                });
            } else {
                // Shrink sidebar (icons only)
                sidebar.classList.remove('w-56');
                sidebar.classList.remove('p-6');
                sidebar.classList.add('w-16');
                sidebar.classList.add('p-2');
                document.querySelectorAll('.sidebar-text').forEach(el => {
                    el.classList.add('hidden');
                });
                document.querySelectorAll('.sidebar-link').forEach(el => {
                    el.classList.remove('justify-start');
                    el.classList.add('justify-center');
                });
            }
        });
    </script>
</body>
</html>
