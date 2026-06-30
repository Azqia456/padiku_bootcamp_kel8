<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'Dashboard') - PADIKU Dinas Pertanian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AlpineJS CDN for Breeze modals & forms -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        :root {
            --hijau-utama: #166534;
            --hijau-sekunder: #15803d;
            --hijau-muda: #22c55e;
            --emas-utama: #FACC15;
            --emas-terang: #FEF08A;
            --card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #F8FAFC; 
        }
        .bg-hijau-utama { background-color: var(--hijau-utama); }
        .bg-hijau-sekunder { background-color: var(--hijau-sekunder); }
        .bg-hijau-muda { background-color: var(--hijau-muda); }
        .bg-emas-utama { background-color: var(--emas-utama); }
        .text-hijau-utama { color: var(--hijau-utama); }
        .text-emas-utama { color: var(--emas-utama); }
        .border-hijau-utama { border-color: var(--hijau-utama); }
        
        /* Premium Design Style Guidelines */
        .rounded-premium {
            border-radius: 20px;
        }
        .shadow-premium {
            box-shadow: var(--card-shadow);
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        .glassmorphism-green {
            background: rgba(22, 101, 52, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(22, 101, 52, 0.15);
        }
        .stat-card { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        }
        .stat-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 20px 40px -10px rgba(22, 101, 52, 0.1); 
        }
    </style>
    @stack('styles')
</head>
<body class="text-slate-800 antialiased">
    @php
        $activeMenu = $activeMenu ?? '';
        $sidebarItems = [
            ['key' => 'dashboard', 'route' => 'dashboard', 'label' => 'Dashboard Utama', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['key' => 'farmers', 'route' => 'dashboard.farmers', 'label' => 'Manajemen Petani', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
            ['key' => 'map', 'route' => 'dashboard.map', 'label' => 'Monitoring Lahan', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
            ['key' => 'plantings', 'route' => 'dashboard.plantings', 'label' => 'Monitoring Tanam', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['key' => 'pest', 'route' => 'dashboard.pest-monitoring', 'label' => 'Monitoring Hama', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
            ['key' => 'fertilizer', 'route' => 'dashboard.fertilizer', 'label' => 'Distribusi Pupuk', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
        ];
    @endphp

    <div class="flex flex-col min-h-screen">
        <!-- Top Navigation Bar -->
        <header class="bg-white border-b border-slate-100 sticky top-0 z-30 shadow-sm">
            <div class="px-6 py-3.5 flex items-center justify-between gap-4">
                
                <!-- Left Side: Hamburger, Logo, Title -->
                <div class="flex items-center gap-4 shrink-0">
                    <button id="hamburgerToggle" class="p-2.5 rounded-xl hover:bg-slate-50 text-slate-600 active:scale-95 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center ring-2 ring-emerald-500/10">
                            <img src="{{ asset('images/logo_padi.png') }}" alt="PADIKU" class="w-8 h-8 rounded-full object-cover">
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 tracking-tight text-lg block leading-none">PADIKU</span>
                            <span class="text-[10px] text-emerald-700 font-bold uppercase tracking-wider block mt-0.5">Dinas Pertanian</span>
                        </div>
                    </a>
                </div>

                <!-- Center: Large Search Bar -->
                <div class="flex-1 max-w-xl mx-auto hidden md:block">
                    <div class="relative">
                        <input type="text" placeholder="Cari data pertanian, petani, atau lahan..."
                               class="w-full px-5 py-2.5 rounded-full bg-slate-50 border border-slate-200/60 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 transition text-sm">
                    </div>
                </div>

                <!-- Right Side: Notifications, Admin Profile -->
                <div class="flex items-center gap-4 shrink-0">
                    
                    <!-- Notification Widget -->
                    <div class="relative" id="notificationDropdownContainer">
                        <button id="notificationDropdownBtn" class="relative p-2.5 rounded-full hover:bg-slate-50 text-slate-600 transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <!-- Dynamic Badge -->
                            <span id="notificationBadge" class="absolute top-2 right-2 flex h-3 w-3 hidden">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500 text-[8px] font-bold text-slate-900 items-center justify-center" id="notificationBadgeCount">0</span>
                            </span>
                        </button>
                        
                        <!-- Notification Dropdown Menu -->
                        <div id="notificationDropdownMenu" class="absolute right-0 mt-2.5 w-80 sm:w-96 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 hidden z-50 transform origin-top-right transition-all duration-200 max-h-[450px] overflow-y-auto">
                            <div class="px-4 py-2.5 border-b border-slate-50 flex items-center justify-between">
                                <p class="text-xs font-bold text-slate-800 uppercase tracking-wider">Peringatan Dini & Notifikasi</p>
                                <span class="text-[10px] bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-bold" id="notificationHeaderCount">0 Baru</span>
                            </div>
                            <div class="divide-y divide-slate-50" id="notificationList">
                                <div class="px-4 py-6 text-center text-xs text-slate-400">Memuat notifikasi...</div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Profile Widget -->
                    @auth
                        <div class="relative" id="profileDropdownContainer">
                            <button id="profileDropdownBtn" class="flex items-center gap-3 pl-3 py-1.5 pr-2 rounded-full hover:bg-slate-50 border border-transparent hover:border-slate-100 transition duration-200 select-none">
                                <div class="hidden sm:block text-right">
                                    <p class="text-xs font-semibold text-slate-700 leading-tight">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] text-slate-400">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="w-9 h-9 bg-emerald-700 text-white rounded-full flex items-center justify-center font-bold text-sm ring-2 ring-emerald-500/20">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </button>
                            
                            <!-- Profile Dropdown Menu -->
                            <div id="profileDropdownMenu" class="absolute right-0 mt-2.5 w-48 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 hidden z-40 transform origin-top-right transition-all duration-200">
                                <div class="px-4 py-2 border-b border-slate-50">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Aksi Admin</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Edit Profil
                                </a>
                                <hr class="border-slate-100 my-1">
                                <button onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50/50 transition text-left font-medium">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                                <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-5 py-2.5 rounded-full transition shadow-sm">Login</a>
                    @endauth
                    
                </div>
            </div>
        </header>

        <!-- Collapsible Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/40 z-30 transition-opacity duration-300 opacity-0 pointer-events-none"></div>

        <!-- Collapsible Sidebar Drawer -->
        <aside id="collapsibleSidebar" class="fixed top-0 bottom-0 left-0 w-72 bg-[#166534] text-white flex flex-col z-40 transform -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl">
            <!-- Header inside sidebar -->
            <div class="p-6 border-b border-white/10 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo_padi.png') }}" alt="PADIKU" class="w-9 h-9 rounded-full object-cover ring-2 ring-[#FACC15]">
                    <div>
                        <p class="font-bold text-base leading-none">PADIKU</p>
                        <p class="text-[10px] text-emerald-200 font-semibold tracking-wider mt-0.5">Dinas Pertanian</p>
                    </div>
                </div>
                <button id="sidebarCloseBtn" class="p-1.5 rounded-lg hover:bg-white/10 text-white transition active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                @foreach($sidebarItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 {{ $activeMenu === $item['key'] ? 'bg-[#FACC15]/20 text-[#FACC15] font-semibold border-l-4 border-[#FACC15]' : 'hover:bg-white/5 text-emerald-100 hover:text-white' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                        <span class="text-sm font-medium">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- Footer inside sidebar -->
            <div class="p-6 border-t border-white/10">
                <div class="bg-white/5 rounded-2xl p-4 border border-white/5">
                    <p class="text-[10px] text-emerald-200 uppercase font-bold tracking-wider mb-1">Status Sistem</p>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        <p class="text-xs font-semibold text-[#FACC15]">Online</p>
                    </div>
                    <p class="text-[10px] text-emerald-300 mt-2 font-medium">{{ now()->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 lg:p-8 max-w-7xl w-full mx-auto">
            @yield('content')
        </main>
    </div>

    <!-- Scripts for Core Actions -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Controls
            const hamburgerToggle = document.getElementById('hamburgerToggle');
            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
            const collapsibleSidebar = document.getElementById('collapsibleSidebar');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            function openSidebar() {
                collapsibleSidebar.classList.remove('-translate-x-full');
                sidebarBackdrop.classList.remove('opacity-0', 'pointer-events-none');
                sidebarBackdrop.classList.add('opacity-100', 'pointer-events-auto');
            }

            function closeSidebar() {
                collapsibleSidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
                sidebarBackdrop.classList.add('opacity-0', 'pointer-events-none');
            }

            hamburgerToggle?.addEventListener('click', openSidebar);
            sidebarCloseBtn?.addEventListener('click', closeSidebar);
            sidebarBackdrop?.addEventListener('click', closeSidebar);

            // Profile Dropdown Controls
            const profileDropdownBtn = document.getElementById('profileDropdownBtn');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');
            const profileDropdownContainer = document.getElementById('profileDropdownContainer');

            if (profileDropdownBtn && profileDropdownMenu) {
                profileDropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isHidden = profileDropdownMenu.classList.contains('hidden');
                    if (isHidden) {
                        profileDropdownMenu.classList.remove('hidden');
                        setTimeout(() => {
                            profileDropdownMenu.classList.remove('scale-95', 'opacity-0');
                        }, 20);
                    } else {
                        profileDropdownMenu.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            profileDropdownMenu.classList.add('hidden');
                        }, 200);
                    }
                });

                document.addEventListener('click', (e) => {
                    if (profileDropdownContainer && !profileDropdownContainer.contains(e.target)) {
                        profileDropdownMenu.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            profileDropdownMenu.classList.add('hidden');
                        }, 200);
                    }
                });
            }

            // Notification Dropdown Controls
            const notificationDropdownBtn = document.getElementById('notificationDropdownBtn');
            const notificationDropdownMenu = document.getElementById('notificationDropdownMenu');
            const notificationDropdownContainer = document.getElementById('notificationDropdownContainer');
            const notificationBadge = document.getElementById('notificationBadge');
            const notificationBadgeCount = document.getElementById('notificationBadgeCount');
            const notificationHeaderCount = document.getElementById('notificationHeaderCount');
            const notificationList = document.getElementById('notificationList');

            // Fetch and render notifications
            async function loadNotifications() {
                try {
                    const response = await fetch("{{ route('dashboard.notifications-data') }}");
                    if (!response.ok) throw new Error("Gagal mengambil data");
                    const data = await response.json();
                    
                    // Update Badge
                    if (data.totalCount > 0) {
                        notificationBadge.classList.remove('hidden');
                        notificationBadgeCount.innerText = data.totalCount;
                        notificationHeaderCount.innerText = `${data.totalCount} Baru`;
                    } else {
                        notificationBadge.classList.add('hidden');
                        notificationHeaderCount.innerText = "0 Baru";
                    }

                    // Render list
                    if (data.notifications && data.notifications.length > 0) {
                        notificationList.innerHTML = data.notifications.map(item => {
                            let iconSvg = '';
                            let typeBg = 'bg-slate-100 text-slate-700';
                            
                            if (item.type === 'pest') {
                                typeBg = 'bg-red-50 text-red-700 border border-red-100';
                                iconSvg = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`;
                            } else if (item.type === 'harvest') {
                                typeBg = 'bg-yellow-50 text-yellow-800 border border-yellow-100';
                                iconSvg = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
                            } else {
                                typeBg = 'bg-emerald-50 text-emerald-700 border border-emerald-100';
                                iconSvg = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>`;
                            }

                            return `
                                <div class="px-4 py-3 hover:bg-slate-50/70 transition flex gap-3 items-start">
                                    <div class="p-2 rounded-xl shrink-0 ${typeBg}">
                                        ${iconSvg}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-800 leading-snug">${item.title}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5 leading-normal">${item.message}</p>
                                        <p class="text-[10px] text-slate-400 mt-1 font-medium">${item.time}</p>
                                    </div>
                                </div>
                            `;
                        }).join('');
                    } else {
                        notificationList.innerHTML = `
                            <div class="px-4 py-8 text-center text-xs text-slate-400 font-medium">
                                Tidak ada peringatan dini atau notifikasi aktif.
                            </div>
                        `;
                    }
                } catch (error) {
                    console.error("Gagal memuat notifikasi:", error);
                    notificationList.innerHTML = `
                        <div class="px-4 py-8 text-center text-xs text-red-500 font-medium">
                            Gagal memuat notifikasi.
                        </div>
                    `;
                }
            }

            // Toggle Dropdown
            if (notificationDropdownBtn && notificationDropdownMenu) {
                notificationDropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isHidden = notificationDropdownMenu.classList.contains('hidden');
                    
                    // Close profile dropdown if open
                    if (profileDropdownMenu) {
                        profileDropdownMenu.classList.add('scale-95', 'opacity-0', 'hidden');
                    }

                    if (isHidden) {
                        notificationDropdownMenu.classList.remove('hidden');
                        loadNotifications(); // Reload fresh data
                    } else {
                        notificationDropdownMenu.classList.add('hidden');
                    }
                });

                document.addEventListener('click', (e) => {
                    if (notificationDropdownContainer && !notificationDropdownContainer.contains(e.target)) {
                        notificationDropdownMenu.classList.add('hidden');
                    }
                });
            }

            // Initial load on page ready
            loadNotifications();
        });
    </script>
    @stack('scripts')
</body>
</html>
