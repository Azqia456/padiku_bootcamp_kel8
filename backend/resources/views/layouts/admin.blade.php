<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PADIKU Dinas Pertanian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --hijau-utama: #0A5C34;
            --hijau-sekunder: #2E7D32;
            --hijau-muda: #63A52F;
            --emas-utama: #F2C230;
            --emas-terang: #FFD54F;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-hijau-utama { background-color: var(--hijau-utama); }
        .bg-hijau-sekunder { background-color: var(--hijau-sekunder); }
        .bg-hijau-muda { background-color: var(--hijau-muda); }
        .bg-emas-utama { background-color: var(--emas-utama); }
        .text-hijau-utama { color: var(--hijau-utama); }
        .text-emas-utama { color: var(--emas-utama); }
        .border-hijau-utama { border-color: var(--hijau-utama); }
        .sidebar-link.active { background-color: rgba(242, 194, 48, 0.18); border-left: 4px solid var(--emas-utama); }
        .sidebar-link:hover:not(.active) { background-color: rgba(255, 255, 255, 0.08); }
        .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(10, 92, 52, 0.12); }
        .hero-overlay { background: linear-gradient(135deg, rgba(10,92,52,0.92) 0%, rgba(46,125,50,0.78) 60%, rgba(10,92,52,0.85) 100%); }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    @php
        $activeMenu = $activeMenu ?? '';
        $sidebarItems = [
            ['key' => 'dashboard', 'route' => 'dashboard', 'label' => 'Dashboard Utama', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['key' => 'farmers', 'route' => 'dashboard.farmers', 'label' => 'Manajemen Petani', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
            ['key' => 'map', 'route' => 'dashboard.map', 'label' => 'Monitoring Lahan', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
            ['key' => 'plantings', 'route' => 'dashboard.plantings', 'label' => 'Monitoring Tanam', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['key' => 'pest', 'route' => 'dashboard.pest-monitoring', 'label' => 'Monitoring Hama', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
            ['key' => 'fertilizer', 'route' => 'dashboard.fertilizer', 'label' => 'Distribusi Pupuk', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
            ['key' => 'food-balance', 'route' => 'dashboard.food-balance', 'label' => 'Neraca Pangan', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
            ['key' => 'early-warning', 'route' => 'dashboard.early-warning', 'label' => 'Early Warning', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
    @endphp

    <div class="flex min-h-screen">
        <aside id="sidebar" class="w-64 bg-hijau-utama text-white flex flex-col transition-all duration-300 ease-in-out shrink-0">
            <div class="p-5 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo_padi.png') }}" alt="PADIKU" class="w-10 h-10 rounded-full object-cover ring-2 ring-emas-utama sidebar-logo">
                    <div class="sidebar-text">
                        <p class="font-bold text-sm leading-tight">PADIKU</p>
                        <p class="text-xs text-green-200">Dinas Pertanian</p>
                    </div>
                    <button id="sidebarToggle" class="ml-auto p-1.5 rounded-lg hover:bg-white/10 transition sidebar-text">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                @foreach($sidebarItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ $activeMenu === $item['key'] ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                        <span class="sidebar-text text-sm font-medium">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="p-4 border-t border-white/10 sidebar-text">
                <div class="bg-white/10 rounded-xl p-4">
                    <p class="text-xs text-green-200 mb-1">Status Sistem</p>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        <p class="text-sm font-semibold text-emas-utama">Online</p>
                    </div>
                    <p class="text-xs text-green-300 mt-1">{{ now()->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-hijau-utama text-white shadow-md sticky top-0 z-20">
                <div class="px-6 py-4 flex items-center justify-between gap-4">
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" placeholder="Cari data pertanian..."
                                   class="w-full px-4 py-2.5 pl-10 rounded-xl bg-white/15 text-white placeholder-green-200 focus:outline-none focus:ring-2 focus:ring-emas-utama text-sm">
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <button class="relative p-2 rounded-xl hover:bg-white/10 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-emas-utama rounded-full"></span>
                        </button>
                        @auth
                            <div class="flex items-center gap-3 pl-4 border-l border-white/20">
                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-green-200">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="w-10 h-10 bg-emas-utama rounded-full flex items-center justify-center ring-2 ring-white/30">
                                    <span class="text-hijau-utama font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm bg-emas-utama text-hijau-utama font-semibold px-4 py-2 rounded-xl hover:bg-yellow-300 transition">Login</a>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        let isExpanded = true;

        sidebarToggle?.addEventListener('click', () => {
            isExpanded = !isExpanded;
            if (isExpanded) {
                sidebar.classList.remove('w-[72px]');
                sidebar.classList.add('w-64');
                document.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('hidden'));
            } else {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-[72px]');
                document.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
