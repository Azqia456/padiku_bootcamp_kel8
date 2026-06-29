@php $activeMenu = 'dashboard'; @endphp
@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
<!-- Hero Section -->
<section class="relative rounded-premium overflow-hidden mb-8 shadow-premium bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-800 text-white min-h-[220px] flex items-center">
    <div class="absolute inset-0 opacity-20 bg-cover bg-center" style="background-image: url('{{ asset('images/bg_db.png') }}'); mix-blend-mode: overlay;"></div>
    
    <!-- Decorative Green Glows -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-600/30 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-yellow-500/20 rounded-full blur-3xl"></div>

    <div class="relative z-10 p-8 md:p-10 w-full flex items-center">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-white/10 text-[10px] font-bold uppercase tracking-wider text-emerald-200 px-3.5 py-1.5 rounded-full mb-4 border border-white/10 backdrop-blur-md">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span>
                Dinas Pertanian Karawang
            </div>
            <h1 class="text-2xl md:text-3.5xl font-extrabold text-white mb-2 tracking-tight leading-tight">
                Selamat Datang di Dashboard PADIKU
            </h1>
            <p class="text-emerald-100/90 text-sm md:text-base font-medium leading-relaxed">
                Platform Digital Pertanian Kabupaten Karawang untuk monitoring lahan, produksi, petani, distribusi pupuk, dan sistem peringatan dini.
            </p>
        </div>
    </div>
</section>

<!-- Summary Cards (6 Cards in 1 Row) -->
<section class="mb-5">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        
        <!-- Total Sawah -->
        <div class="stat-card bg-white rounded-premium border border-slate-100 border-l-4 border-emerald-700 p-5 flex flex-col justify-between shadow-emerald-premium transition-all duration-300">
            <div class="flex justify-end mb-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 flex items-center gap-0.5">
                    +2.4%
                </span>
            </div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold mb-1 uppercase tracking-wider">Total Sawah</p>
                <p class="text-xl font-bold text-slate-800 leading-tight">
                    {{ number_format($totalArea, 1) }} <span class="text-sm font-medium text-slate-500">Ha</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-1">Luas sawah terdaftar</p>
            </div>
        </div>

        <!-- Total Produksi -->
        <div class="stat-card bg-white rounded-premium border border-slate-100 border-l-4 border-emerald-600 p-5 flex flex-col justify-between shadow-emerald-premium transition-all duration-300">
            <div class="flex justify-end mb-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 flex items-center gap-0.5">
                    +3.8%
                </span>
            </div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold mb-1 uppercase tracking-wider">Total Produksi</p>
                <p class="text-xl font-bold text-slate-800 leading-tight">
                    {{ number_format($totalArea * 5, 0) }} <span class="text-sm font-medium text-slate-500">ton</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-1">Estimasi hasil panen</p>
            </div>
        </div>

        <!-- Total Petani -->
        <div class="stat-card bg-white rounded-premium border border-slate-100 border-l-4 border-emerald-500 p-5 flex flex-col justify-between shadow-emerald-premium transition-all duration-300">
            <div class="flex justify-end mb-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 flex items-center gap-0.5">
                    +12
                </span>
            </div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold mb-1 uppercase tracking-wider">Total Petani</p>
                <p class="text-xl font-bold text-slate-800 leading-tight">
                    {{ $totalFarmers }} <span class="text-sm font-medium text-slate-500">orang</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-1">Petani aktif terdaftar</p>
            </div>
        </div>

        <!-- Laporan Hama -->
        <div class="stat-card bg-white rounded-premium border border-slate-100 border-l-4 border-red-500 p-5 flex flex-col justify-between shadow-red-premium transition-all duration-300">
            <div class="flex justify-end mb-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 flex items-center gap-0.5">
                    -5.2%
                </span>
            </div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold mb-1 uppercase tracking-wider">Laporan Hama</p>
                <p class="text-xl font-bold text-slate-800 leading-tight">
                    {{ $activePestReports }} / {{ $totalPestReports }}
                </p>
                <p class="text-[10px] text-slate-400 mt-1">Laporan Hama Aktif</p>
            </div>
        </div>

        <!-- Lahan Terdaftar -->
        <div class="stat-card bg-white rounded-premium border border-slate-100 border-l-4 border-emerald-800 p-5 flex flex-col justify-between shadow-emerald-premium transition-all duration-300">
            <div class="flex justify-end mb-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 flex items-center gap-0.5">
                    +4.2%
                </span>
            </div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold mb-1 uppercase tracking-wider">Lahan Tanam</p>
                <p class="text-xl font-bold text-slate-800 leading-tight">
                    {{ $totalPlantings }} <span class="text-sm font-medium text-slate-500">titik</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-1">Lahan terpetakan</p>
            </div>
        </div>

        <!-- Distribusi Pupuk -->
        <div class="stat-card bg-white rounded-premium border border-slate-100 border-l-4 border-emerald-600 p-5 flex flex-col justify-between shadow-emerald-premium transition-all duration-300">
            <div class="flex justify-end mb-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 flex items-center gap-0.5">
                    +8
                </span>
            </div>
            <div>
                <p class="text-slate-400 text-[10px] font-bold mb-1 uppercase tracking-wider">Pupuk</p>
                <p class="text-xl font-bold text-slate-800 leading-tight">
                    {{ $totalFertilizer }} <span class="text-sm font-medium text-slate-500">jadwal</span>
                </p>
                <p class="text-[10px] text-slate-400 mt-1">Jadwal distribusi</p>
            </div>
        </div>
    </div>
</section>

<!-- Analytics Section -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Agricultural Production Chart -->
    <div class="lg:col-span-2 bg-white rounded-premium shadow-premium p-6 border border-slate-100 flex flex-col justify-between min-h-[380px]">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-slate-800 text-base leading-none">Grafik Produksi Pertanian</h3>
                <span class="text-slate-400 text-xs mt-1 block">Produksi lahan bulanan (Hektar) di Karawang</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-700"></span>
                <span class="text-xs font-bold text-slate-600">Total Luas Area</span>
            </div>
        </div>
        <div class="flex-1 relative min-h-[260px]">
            <canvas id="productionChart"></canvas>
        </div>
    </div>

    <!-- Land Area Distribution -->
    <div class="bg-white rounded-premium shadow-premium p-6 border border-slate-100 flex flex-col justify-between min-h-[380px]">
        <div>
            <h3 class="font-bold text-slate-800 text-base leading-none">Sebaran Luas Lahan</h3>
            <span class="text-slate-400 text-xs mt-1 block">Distribusi komoditas dan tipe lahan pertanian</span>
        </div>
        <div class="flex-1 relative flex items-center justify-center my-4 min-h-[200px]">
            <canvas id="landDistributionChart"></canvas>
            <!-- Center Text Overlay -->
            <div class="absolute flex flex-col items-center justify-center pointer-events-none select-none">
                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest leading-none">Total Lahan</span>
                <span class="text-2xl font-black text-slate-800 leading-tight mt-1">
                    450.5
                </span>
                <span class="text-[9px] font-bold text-emerald-800 leading-none">Hektar (Ha)</span>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2 text-xs">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-700 shrink-0"></span>
                <span class="text-slate-600 truncate">Sawah (65%)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                <span class="text-slate-600 truncate">Ladang (15%)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 shrink-0"></span>
                <span class="text-slate-600 truncate">Perkebunan (12%)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-600 shrink-0"></span>
                <span class="text-slate-600 truncate">Hortikultura (8%)</span>
            </div>
        </div>
    </div>
</section>

<!-- Bottom Section (Three Columns) -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Card 1: Recent Farmer Registrations -->
    <div class="bg-white rounded-premium shadow-premium p-6 border border-slate-100 flex flex-col h-[400px]">
        <div class="flex items-center justify-between mb-4 shrink-0">
            <div>
                <h3 class="font-bold text-slate-800 text-base leading-none">Pendaftaran Petani Terbaru</h3>
                <span class="text-slate-400 text-xs mt-1 block">5 Petani yang baru terdaftar</span>
            </div>
            <a href="{{ route('dashboard.farmers') }}" class="text-xs font-bold text-emerald-700 hover:underline">Lihat Semua</a>
        </div>
        <div class="flex-1 overflow-y-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 font-bold border-b border-slate-50 pb-2">
                        <th class="pb-2">Nama</th>
                        <th class="pb-2">Kecamatan</th>
                        <th class="pb-2">Luas</th>
                        <th class="pb-2 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentFarmers as $farmer)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 font-semibold text-slate-700">{{ $farmer->name }}</td>
                            <td class="py-3 text-slate-500">{{ $farmer->district ?? '-' }}</td>
                            <td class="py-3 font-medium text-slate-700">{{ number_format($farmer->plantings()->sum('area_hectares'), 1) }} Ha</td>
                            <td class="py-3 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold {{ $farmer->plantings_count > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $farmer->plantings_count > 0 ? 'Aktif' : 'Baru' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <!-- Mockup fallback data for demonstration -->
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 font-semibold text-slate-700">Asep Setiawan</td>
                            <td class="py-3 text-slate-500">Klari</td>
                            <td class="py-3 font-medium text-slate-700">4.5 Ha</td>
                            <td class="py-3 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 font-semibold text-slate-700">Budi Rahardjo</td>
                            <td class="py-3 text-slate-500">Rawamerta</td>
                            <td class="py-3 font-medium text-slate-700">3.2 Ha</td>
                            <td class="py-3 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 font-semibold text-slate-700">Cecep Mulyana</td>
                            <td class="py-3 text-slate-500">Telukjambe Barat</td>
                            <td class="py-3 font-medium text-slate-700">0.0 Ha</td>
                            <td class="py-3 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-700">Baru</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 font-semibold text-slate-700">Dedi Sutisna</td>
                            <td class="py-3 text-slate-500">Cikampek</td>
                            <td class="py-3 font-medium text-slate-700">2.8 Ha</td>
                            <td class="py-3 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card 2: Latest Pest Reports -->
    <div class="bg-white rounded-premium shadow-premium p-6 border border-slate-100 flex flex-col h-[400px]">
        <div class="flex items-center justify-between mb-4 shrink-0">
            <div>
                <h3 class="font-bold text-slate-800 text-base leading-none">Laporan Hama Terbaru</h3>
                <span class="text-slate-400 text-xs mt-1 block">Update serangan hama terkini</span>
            </div>
            <a href="{{ route('dashboard.pest-monitoring') }}" class="text-xs font-bold text-[#166534] hover:underline">Lihat Semua</a>
        </div>
        <div class="flex-1 overflow-y-auto pr-1">
            <div class="space-y-4 relative before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-100">
                @forelse($recentPestReports->take(4) as $report)
                    @php
                        $sevColor = [
                            'low' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'medium' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            'high' => 'bg-orange-50 text-orange-700 border-orange-200',
                            'critical' => 'bg-red-50 text-red-700 border-red-200',
                        ][$report->severity] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                        
                        $dotColor = [
                            'low' => 'bg-emerald-500 ring-emerald-200',
                            'medium' => 'bg-yellow-500 ring-yellow-200',
                            'high' => 'bg-orange-500 ring-orange-200',
                            'critical' => 'bg-red-500 ring-red-200',
                        ][$report->severity] ?? 'bg-slate-500 ring-slate-200';
                    @endphp
                    <div class="flex gap-4 relative pl-7">
                        <div class="absolute left-1.5 top-1.5 w-3.5 h-3.5 rounded-full {{ $dotColor }} ring-4 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                        <div class="flex-1 bg-slate-50/50 hover:bg-slate-50 border border-slate-100/50 rounded-xl p-3 transition duration-150">
                            <div class="flex justify-between items-start gap-2 mb-1">
                                <span class="font-bold text-xs text-slate-700 leading-tight block">{{ $report->pest_type }}</span>
                                <span class="px-2 py-0.5 rounded text-[8px] font-extrabold uppercase border {{ $sevColor }} shrink-0">
                                    {{ $report->severity }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-[10px] text-slate-400 mt-2">
                                <span class="font-semibold text-emerald-800">{{ $report->user->district ?? 'Karawang' }}</span>
                                <span>{{ $report->report_date?->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Mockup fallback data for demonstration -->
                    <div class="flex gap-4 relative pl-7">
                        <div class="absolute left-1.5 top-1.5 w-3.5 h-3.5 rounded-full bg-red-500 ring-red-100 ring-4 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                        <div class="flex-1 bg-slate-50/50 border border-slate-100 rounded-xl p-3">
                            <div class="flex justify-between items-start gap-2 mb-1">
                                <span class="font-bold text-xs text-slate-700 block">Wereng Coklat</span>
                                <span class="px-2 py-0.5 rounded text-[8px] font-extrabold uppercase border bg-red-50 text-red-700 border-red-200">Critical</span>
                            </div>
                            <p class="text-[10px] text-slate-500 line-clamp-1">Serangan wereng mematikan batang padi seluas 2 hektar.</p>
                            <div class="flex justify-between items-center text-[10px] text-slate-400 mt-2">
                                <span class="font-semibold text-emerald-800">Rawamerta</span>
                                <span>28 Jun 2026</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4 relative pl-7">
                        <div class="absolute left-1.5 top-1.5 w-3.5 h-3.5 rounded-full bg-yellow-500 ring-yellow-100 ring-4 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                        <div class="flex-1 bg-slate-50/50 border border-slate-100 rounded-xl p-3">
                            <div class="flex justify-between items-start gap-2 mb-1">
                                <span class="font-bold text-xs text-slate-700 block">Ulat Grayak</span>
                                <span class="px-2 py-0.5 rounded text-[8px] font-extrabold uppercase border bg-yellow-50 text-yellow-700 border-yellow-200">Medium</span>
                            </div>
                            <p class="text-[10px] text-slate-500 line-clamp-1">Daun padi robek-robek di bagian pinggir.</p>
                            <div class="flex justify-between items-center text-[10px] text-slate-400 mt-2">
                                <span class="font-semibold text-emerald-800">Klari</span>
                                <span>27 Jun 2026</span>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Card 3: Weather & Early Warning -->
    <div class="bg-white rounded-premium shadow-premium p-6 border border-slate-100 flex flex-col justify-between h-[400px]">
        <div>
            <h3 class="font-bold text-slate-800 text-base leading-none">Weather & Early Warning</h3>
            <span class="text-slate-400 text-xs mt-1 block">Kondisi cuaca dan status mitigasi sawah</span>
        </div>
        
        <!-- Weather Info Box -->
        <div class="bg-gradient-to-br from-emerald-50 to-green-100/50 border border-emerald-100/80 rounded-2xl p-4 flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-xs font-bold">Karawang, Hari Ini</p>
                <p class="text-2xl font-black text-[#166534] mt-1">Cerah Berawan</p>
                <div class="flex items-center gap-4 mt-3">
                    <div>
                        <span class="text-[10px] text-slate-400 block leading-none font-bold">Suhu</span>
                        <span class="text-sm font-extrabold text-slate-700">31°C</span>
                    </div>
                    <div class="w-px h-6 bg-slate-200"></div>
                    <div>
                        <span class="text-[10px] text-slate-400 block leading-none font-bold">Curah Hujan</span>
                        <span class="text-sm font-extrabold text-slate-700">12mm</span>
                    </div>
                </div>
            </div>
            
            <!-- Weather SVG Illustration -->
            <div class="w-16 h-16 shrink-0 relative">
                <svg viewBox="0 0 64 64" class="w-full h-full text-[#FACC15]">
                    <circle cx="32" cy="24" r="12" fill="currentColor"/>
                    <path d="M46 44a10 10 0 00-10-10h-2.5a12.5 12.5 0 00-23.5 4A8.5 8.5 0 0018.5 55H46a10 10 0 000-20z" fill="#E2E8F0" class="text-slate-200"/>
                </svg>
            </div>
        </div>

        <!-- Early Warning System (EWS) Alert -->
        <div class="border-t border-slate-100 pt-4">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Status EWS Lahan</p>
            @if($activePestReports > 0)
                <div class="bg-red-50 border border-red-200 rounded-xl p-3.5 flex gap-3 items-start">
                    <span class="text-red-500 shrink-0 text-xl mt-0.5">⚠️</span>
                    <div>
                        <p class="font-bold text-xs text-red-800">Status: Waspada Hama</p>
                        <p class="text-[10px] text-red-600 mt-0.5 leading-relaxed">Terdeteksi {{ $activePestReports }} serangan hama aktif di beberapa wilayah. Segera tindaklanjuti laporan petani.</p>
                    </div>
                </div>
            @else
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3.5 flex gap-3 items-start">
                    <span class="text-emerald-500 shrink-0 text-xl mt-0.5">✅</span>
                    <div>
                        <p class="font-bold text-xs text-emerald-800">Status: Lahan Aman</p>
                        <p class="text-[10px] text-emerald-600 mt-0.5 leading-relaxed">Kondisi lahan pertanian di seluruh kecamatan terpantau aman dan terkendali dari serangan hama skala besar.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Floating Quick Actions Panel -->
<div class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-3" id="quickActionsContainer">
    <!-- Collapsible Menu -->
    <div id="quickActionsMenu" class="hidden flex-col items-end gap-2.5 mb-2 transform origin-bottom transition-all duration-200 opacity-0 scale-90 translate-y-4">
        
        <!-- Action: Tambah Petani -->
        <button onclick="openModal('modalFarmer')" class="flex items-center gap-3 bg-white hover:bg-slate-50 border border-slate-100 rounded-full py-2 px-4 shadow-xl text-xs font-bold text-slate-700 transition active:scale-95 group">
            <span class="group-hover:text-emerald-700 transition">Tambah Petani</span>
            <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">👨‍🌾</span>
        </button>

        <!-- Action: Tambah Lahan -->
        <button onclick="openModal('modalPlanting')" class="flex items-center gap-3 bg-white hover:bg-slate-50 border border-slate-100 rounded-full py-2 px-4 shadow-xl text-xs font-bold text-slate-700 transition active:scale-95 group">
            <span class="group-hover:text-emerald-700 transition">Tambah Lahan</span>
            <span class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center text-sm font-bold">📍</span>
        </button>

        <!-- Action: Tambah Produksi -->
        <button onclick="openModal('modalPlanting')" class="flex items-center gap-3 bg-white hover:bg-slate-50 border border-slate-100 rounded-full py-2 px-4 shadow-xl text-xs font-bold text-slate-700 transition active:scale-95 group">
            <span class="group-hover:text-emerald-700 transition">Tambah Produksi</span>
            <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold">🌱</span>
        </button>

        <!-- Action: Tambah Laporan Hama -->
        <button onclick="openModal('modalPest')" class="flex items-center gap-3 bg-white hover:bg-slate-50 border border-slate-100 rounded-full py-2 px-4 shadow-xl text-xs font-bold text-slate-700 transition active:scale-95 group">
            <span class="group-hover:text-red-700 transition">Lapor Serangan Hama</span>
            <span class="w-8 h-8 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-sm font-bold">🐛</span>
        </button>
    </div>

    <!-- Main Floating Toggle Button -->
    <button id="quickActionsToggleBtn" class="w-14 h-14 rounded-full bg-[#166534] text-white hover:bg-[#166534]/95 flex items-center justify-center shadow-2xl active:scale-95 hover:rotate-95 transition-all duration-300 ring-4 ring-emerald-500/10">
        <svg id="toggleIcon" class="w-7 h-7 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
    </button>
</div>

<!-- ========================================================================= -->
<!-- MODALS SECTION -->
<!-- ========================================================================= -->

<!-- Modal Backdrop -->
<div id="modalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300"></div>

<!-- Modal 1: Tambah Petani -->
<div id="modalFarmer" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-lg bg-white rounded-premium shadow-2xl z-50 hidden transform scale-95 opacity-0 transition-all duration-300">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
            <span>👨‍🌾</span> Tambah Petani Baru
        </h3>
        <button onclick="closeActiveModal()" class="p-1 rounded-lg hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition">✕</button>
    </div>
    <form id="formFarmer" class="p-6 space-y-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1">NAMA PETANI</label>
            <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">EMAIL</label>
                <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">TELEPON</label>
                <input type="text" name="phone" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">KECAMATAN</label>
                <input type="text" name="district" required placeholder="Contoh: Klari" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">PASSWORD</label>
                <input type="password" name="password" required placeholder="Min 8 Karakter" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1">ALAMAT LENGKAP</label>
            <textarea name="address" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm"></textarea>
        </div>
        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3 text-sm font-semibold">
            <button type="button" onclick="closeActiveModal()" class="px-5 py-2.5 rounded-xl hover:bg-slate-50 text-slate-500 transition">Batal</button>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#166534] hover:bg-[#166534]/95 text-white shadow-lg transition active:scale-95">Simpan Petani</button>
        </div>
    </form>
</div>

<!-- Modal 2: Tambah Lahan / Produksi -->
<div id="modalPlanting" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-lg bg-white rounded-premium shadow-2xl z-50 hidden transform scale-95 opacity-0 transition-all duration-300">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
            <span>📍</span> Tambah Lahan Tanam
        </h3>
        <button onclick="closeActiveModal()" class="p-1 rounded-lg hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition">✕</button>
    </div>
    <form id="formPlanting" class="p-6 space-y-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1">PILIH PETANI</label>
            <select name="user_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm bg-white">
                <option value="">-- Pilih Petani Pemilik Lahan --</option>
                @foreach(\App\Models\User::where('user_type', 'petani')->orderBy('name')->get() as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->district }})</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">NAMA LOKASI LAHAN</label>
                <input type="text" name="location_name" required placeholder="Contoh: Sawah 1 Klari" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">LUAS (HEKTAR)</label>
                <input type="number" step="0.01" min="0.01" name="area_hectares" required placeholder="Contoh: 1.5" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">TANGGAL TANAM</label>
                <input type="date" name="planting_date" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">TANGGAL ESTIMASI PANEN</label>
                <input type="date" name="expected_harvest_date" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1">VARIETAS PADI</label>
            <input type="text" name="rice_variety" required placeholder="Contoh: Ciherang, Inpari 32" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1">CATATAN KHUSUS (OPSIONAL)</label>
            <textarea name="notes" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm"></textarea>
        </div>
        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3 text-sm font-semibold">
            <button type="button" onclick="closeActiveModal()" class="px-5 py-2.5 rounded-xl hover:bg-slate-50 text-slate-500 transition">Batal</button>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#166534] hover:bg-[#166534]/95 text-white shadow-lg transition active:scale-95">Simpan Lahan</button>
        </div>
    </form>
</div>

<!-- Modal 3: Lapor Serangan Hama -->
<div id="modalPest" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-lg bg-white rounded-premium shadow-2xl z-50 hidden transform scale-95 opacity-0 transition-all duration-300">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
            <span>🐛</span> Lapor Serangan Hama
        </h3>
        <button onclick="closeActiveModal()" class="p-1 rounded-lg hover:bg-slate-50 text-slate-400 hover:text-slate-600 transition">✕</button>
    </div>
    <form id="formPest" class="p-6 space-y-4">
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1">PILIH PETANI</label>
            <select id="pestUserSelect" name="user_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm bg-white">
                <option value="">-- Pilih Petani Pelapor --</option>
                @foreach(\App\Models\User::where('user_type', 'petani')->orderBy('name')->get() as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->district }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1">PILIH LAHAN YANG TERDAMPAK</label>
            <select id="pestPlantingSelect" name="planting_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm bg-white">
                <option value="">-- Silakan Pilih Petani Dahulu --</option>
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">JENIS HAMA</label>
                <input type="text" name="pest_type" required placeholder="Contoh: Wereng Coklat" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">TINGKAT KEPARAHAN</label>
                <select name="severity" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm bg-white">
                    <option value="low">Rendah (Low)</option>
                    <option value="medium">Sedang (Medium)</option>
                    <option value="high">Tinggi (High)</option>
                    <option value="critical">Kritis (Critical)</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1">TANGGAL LAPORAN</label>
            <input type="date" name="report_date" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 mb-1">DESKRIPSI GEJALA / SERANGAN</label>
            <textarea name="description" rows="3" required placeholder="Jelaskan secara mendetail tingkat serangan hama..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-700/20 focus:border-emerald-700 text-sm"></textarea>
        </div>
        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3 text-sm font-semibold">
            <button type="button" onclick="closeActiveModal()" class="px-5 py-2.5 rounded-xl hover:bg-slate-50 text-slate-500 transition">Batal</button>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-700 hover:bg-red-800 text-white shadow-lg transition active:scale-95">Kirim Laporan</button>
        </div>
    </form>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="fixed top-6 right-6 z-50 flex flex-col gap-3"></div>

@endsection

@push('scripts')
<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // =========================================================================
    // CHARTS CONFIGURATION
    // =========================================================================
    
    // 1. Line Chart: Agricultural Production (Mocked for presentation)
    const productionCtx = document.getElementById('productionChart').getContext('2d');
    
    const prodLabels = ["Jan 2026", "Feb 2026", "Mar 2026", "Apr 2026", "Mei 2026", "Jun 2026"];
    const prodValues = [712, 841, 977, 1150, 1079, 1302]; // Tons

    const prodGradient = productionCtx.createLinearGradient(0, 0, 0, 300);
    prodGradient.addColorStop(0, 'rgba(22, 101, 52, 0.25)');
    prodGradient.addColorStop(1, 'rgba(22, 101, 52, 0.00)');

    new Chart(productionCtx, {
        type: 'line',
        data: {
            labels: prodLabels,
            datasets: [{
                label: 'Hasil Produksi (Ton)',
                data: prodValues,
                borderColor: '#166534',
                borderWidth: 3,
                pointBackgroundColor: '#166534',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                backgroundColor: prodGradient,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                    bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                    cornerRadius: 12,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    grid: { color: 'rgba(0, 0, 0, 0.04)' },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 10 } }
                }
            }
        }
    });

    // 2. Doughnut Chart: Land Distribution (Mocked for presentation)
    const landCtx = document.getElementById('landDistributionChart').getContext('2d');
    const totalAreaValue = 450.5;

    new Chart(landCtx, {
        type: 'doughnut',
        data: {
            labels: ['Sawah', 'Ladang', 'Perkebunan', 'Hortikultura'],
            datasets: [{
                data: [
                    (totalAreaValue * 0.65).toFixed(1),
                    (totalAreaValue * 0.15).toFixed(1),
                    (totalAreaValue * 0.12).toFixed(1),
                    (totalAreaValue * 0.08).toFixed(1)
                ],
                backgroundColor: ['#166534', '#22c55e', '#facc15', '#d97706'],
                borderWidth: 4,
                borderColor: '#ffffff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                    bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                    callbacks: {
                        label: function(context) {
                            return ` Luas: ${context.raw} Ha`;
                        }
                    },
                    cornerRadius: 12,
                    displayColors: true
                }
            },
            cutout: '72%'
        }
    });

    // =========================================================================
    // FLOATING QUICK ACTIONS MENU TOGGLE
    // =========================================================================
    const quickActionsToggleBtn = document.getElementById('quickActionsToggleBtn');
    const quickActionsMenu = document.getElementById('quickActionsMenu');
    const toggleIcon = document.getElementById('toggleIcon');
    let isMenuExpanded = false;

    quickActionsToggleBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        isMenuExpanded = !isMenuExpanded;
        if (isMenuExpanded) {
            quickActionsMenu.classList.remove('hidden');
            setTimeout(() => {
                quickActionsMenu.classList.remove('opacity-0', 'scale-90', 'translate-y-4');
                toggleIcon.style.transform = 'rotate(135deg)';
            }, 20);
        } else {
            quickActionsMenu.classList.add('opacity-0', 'scale-90', 'translate-y-4');
            toggleIcon.style.transform = 'rotate(0deg)';
            setTimeout(() => {
                quickActionsMenu.classList.add('hidden');
            }, 200);
        }
    });

    document.addEventListener('click', () => {
        if (isMenuExpanded) {
            quickActionsMenu.classList.add('opacity-0', 'scale-90', 'translate-y-4');
            toggleIcon.style.transform = 'rotate(0deg)';
            setTimeout(() => {
                quickActionsMenu.classList.add('hidden');
            }, 200);
            isMenuExpanded = false;
        }
    });

    // =========================================================================
    // MODALS CONTROLS & SUBMIT ACTIONS
    // =========================================================================
    const backdrop = document.getElementById('modalBackdrop');
    let activeModalId = null;

    window.openModal = function(modalId) {
        // Close menu
        if (isMenuExpanded) {
            quickActionsToggleBtn.click();
        }
        
        activeModalId = modalId;
        const modal = document.getElementById(modalId);
        backdrop.classList.remove('hidden');
        modal.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.remove('opacity-0', 'scale-95');
        }, 20);
    };

    window.closeActiveModal = function() {
        if (!activeModalId) return;
        const modal = document.getElementById(activeModalId);
        backdrop.classList.add('opacity-0');
        modal.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            backdrop.classList.add('hidden');
            modal.classList.add('hidden');
            activeModalId = null;
        }, 300);
    };

    backdrop?.addEventListener('click', closeActiveModal);

    // Toast Notification Maker
    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `flex items-center gap-3 px-5 py-4 rounded-2xl shadow-2xl border transform translate-y-4 opacity-0 transition-all duration-300 ${
            type === 'success' 
            ? 'bg-slate-900 border-emerald-500/25 text-white' 
            : 'bg-red-950 border-red-500/20 text-white'
        }`;
        toast.innerHTML = `
            <span class="text-base">${type === 'success' ? '✅' : '❌'}</span>
            <span class="text-xs font-semibold tracking-wide">${message}</span>
        `;
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
        }, 10);

        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    };

    // AJAX Form submissions
    const setupAjaxForm = (formId, url, successMessage) => {
        const form = document.getElementById(formId);
        form?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    showToast(successMessage, 'success');
                    closeActiveModal();
                    form.reset();
                    // Reload data after brief delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    const errorMsg = result.message || 'Gagal menyimpan data. Periksa inputan.';
                    showToast(errorMsg, 'error');
                }
            } catch (err) {
                console.error(err);
                showToast('Koneksi bermasalah. Coba lagi.', 'error');
            }
        });
    };

    setupAjaxForm('formFarmer', "{{ route('dashboard.farmers.store') }}", 'Petani berhasil disimpan! Memuat ulang...');
    setupAjaxForm('formPlanting', "{{ route('dashboard.plantings.store') }}", 'Lahan tanam berhasil disimpan! Memuat ulang...');
    setupAjaxForm('formPest', "{{ route('dashboard.pest-reports.store') }}", 'Laporan hama berhasil dikirim! Memuat ulang...');

    // Dynamic Select Loading for Pest Report Modal
    // When a farmer is selected, fetch/filter their plantings
    const pestUserSelect = document.getElementById('pestUserSelect');
    const pestPlantingSelect = document.getElementById('pestPlantingSelect');

    pestUserSelect?.addEventListener('change', async () => {
        const userId = pestUserSelect.value;
        pestPlantingSelect.innerHTML = '<option value="">-- Memuat Lahan... --</option>';
        if (!userId) {
            pestPlantingSelect.innerHTML = '<option value="">-- Silakan Pilih Petani Dahulu --</option>';
            return;
        }

        try {
            const response = await fetch(`/api/plantings?user_id=${userId}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + '{{ auth()->user()->createToken("temp")->plainTextToken ?? "" }}' // Simple auth fallback
                }
            });
            // Fallback: If Sanctum token fails or isn't set, we can scrape / query from standard client model data or just fetch
            // Let's create a client-side database search using preloaded local blade variables if API fails
            let plantings = [];
            if (response.ok) {
                const apiRes = await response.json();
                plantings = apiRes.data || apiRes;
            } else {
                // Client-side fallback: Get plantings from preloaded javascript if any, or simple ajax
                // To keep it 100% robust, we'll query via web route if API is blocked by sanctum
                // Let's search via standard fetch endpoint if API fails
            }
            
            // Render select
            if (Array.isArray(plantings) && plantings.length > 0) {
                pestPlantingSelect.innerHTML = '<option value="">-- Pilih Lahan Terdampak --</option>';
                plantings.forEach(pl => {
                    pestPlantingSelect.innerHTML += `<option value="${pl.id}">${pl.location_name} (${pl.rice_variety})</option>`;
                });
            } else {
                // If API did not return results due to auth/session issues, we can try to fetch via a simple helper web route,
                // or just query all plantings for the farmer that were preloaded. Let's pre-load all plantings map!
                const preloadedPlantingsMap = {
                    @foreach(\App\Models\User::where('user_type', 'petani')->get() as $u)
                        "{{ $u->id }}": [
                            @foreach($u->plantings as $pl)
                                { id: "{{ $pl->id }}", location_name: "{{ $pl->location_name }}", rice_variety: "{{ $pl->rice_variety }}" },
                            @endforeach
                        ],
                    @endforeach
                };
                
                const localPl = preloadedPlantingsMap[userId] || [];
                if (localPl.length > 0) {
                    pestPlantingSelect.innerHTML = '<option value="">-- Pilih Lahan Terdampak --</option>';
                    localPl.forEach(pl => {
                        pestPlantingSelect.innerHTML += `<option value="${pl.id}">${pl.location_name} (${pl.rice_variety})</option>`;
                    });
                } else {
                    pestPlantingSelect.innerHTML = '<option value="">-- Petani tidak memiliki lahan terdaftar --</option>';
                }
            }
        } catch(e) {
            // Preloaded fallback
            const preloadedPlantingsMap = {
                @foreach(\App\Models\User::where('user_type', 'petani')->get() as $u)
                    "{{ $u->id }}": [
                        @foreach($u->plantings as $pl)
                            { id: "{{ $pl->id }}", location_name: "{{ $pl->location_name }}", rice_variety: "{{ $pl->rice_variety }}" },
                        @endforeach
                    ],
                @endforeach
            };
            const localPl = preloadedPlantingsMap[userId] || [];
            if (localPl.length > 0) {
                pestPlantingSelect.innerHTML = '<option value="">-- Pilih Lahan Terdampak --</option>';
                localPl.forEach(pl => {
                    pestPlantingSelect.innerHTML += `<option value="${pl.id}">${pl.location_name} (${pl.rice_variety})</option>`;
                });
            } else {
                pestPlantingSelect.innerHTML = '<option value="">-- Petani tidak memiliki lahan terdaftar --</option>';
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
/* Custom Colored Shadows to match dashboard metrics theme */
.shadow-emerald-premium {
    box-shadow: 0 10px 25px -5px rgba(22, 101, 52, 0.06), 0 8px 10px -6px rgba(22, 101, 52, 0.06);
}
.shadow-emerald-premium:hover {
    box-shadow: 0 20px 40px -10px rgba(22, 101, 52, 0.16);
}

.shadow-yellow-premium {
    box-shadow: 0 10px 25px -5px rgba(250, 204, 21, 0.06), 0 8px 10px -6px rgba(250, 204, 21, 0.06);
}
.shadow-yellow-premium:hover {
    box-shadow: 0 20px 40px -10px rgba(250, 204, 21, 0.16);
}

.shadow-red-premium {
    box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.06), 0 8px 10px -6px rgba(239, 68, 68, 0.06);
}
.shadow-red-premium:hover {
    box-shadow: 0 20px 40px -10px rgba(239, 68, 68, 0.16);
}
</style>
@endpush