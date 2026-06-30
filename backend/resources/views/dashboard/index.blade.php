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

<!-- Info & Monitoring Section -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Card 1: Compact Neraca Pangan -->
    <div class="bg-white rounded-premium shadow-premium p-6 border border-slate-100 flex flex-col h-[400px] justify-between">
        <div class="mb-4 shrink-0">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="font-bold text-slate-800 text-base leading-none">Neraca Pangan</h3>
                    <span class="text-slate-400 text-xs mt-1 block">Produksi vs Konsumsi Karawang</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm ring-4 ring-emerald-50/50">⚖️</div>
            </div>
        </div>
        
        <div class="flex-1 flex flex-col justify-center">
            @php
                $totalFood = max($foodTotalProduction + $foodTotalConsumption, 1);
                $prodPct = ($foodTotalProduction / $totalFood) * 100;
                $consPct = ($foodTotalConsumption / $totalFood) * 100;
            @endphp
            
            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex justify-between text-xs font-bold mb-2">
                    <span class="text-emerald-700">Produksi ({{ number_format($prodPct, 1) }}%)</span>
                    <span class="text-red-600">Konsumsi ({{ number_format($consPct, 1) }}%)</span>
                </div>
                <div class="h-4 rounded-full overflow-hidden flex bg-slate-100">
                    <div class="bg-emerald-500 h-full transition-all" style="width: {{ $prodPct }}%"></div>
                    <div class="bg-red-400 h-full transition-all" style="width: {{ $consPct }}%"></div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 transition">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-xs font-semibold text-slate-600">Total Produksi</span>
                    </div>
                    <span class="text-sm font-bold text-slate-800">{{ number_format($foodTotalProduction, 1) }} <span class="text-[10px] text-slate-500 font-normal">ton</span></span>
                </div>
                
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 transition">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-400"></span>
                        <span class="text-xs font-semibold text-slate-600">Total Konsumsi</span>
                    </div>
                    <span class="text-sm font-bold text-slate-800">{{ number_format($foodTotalConsumption, 1) }} <span class="text-[10px] text-slate-500 font-normal">ton</span></span>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl border {{ $foodBalance >= 0 ? 'bg-emerald-50 border-emerald-100' : 'bg-red-50 border-red-100' }}">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold {{ $foodBalance >= 0 ? 'text-emerald-700' : 'text-red-700' }}">Status Neraca</span>
                    </div>
                    <span class="text-sm font-bold {{ $foodBalance >= 0 ? 'text-emerald-700' : 'text-red-700' }}">
                        {{ $foodBalance >= 0 ? 'Surplus' : 'Defisit' }} {{ number_format(abs($foodBalance), 1) }} <span class="text-[10px] font-normal {{ $foodBalance >= 0 ? 'text-emerald-600' : 'text-red-600' }}">ton</span>
                    </span>
                </div>
            </div>
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

        <!-- Pesticide Recommendations for Alert Villages -->
        <div class="border-t border-slate-100 pt-4">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Rekomendasi Pestisida Desa Waspada</p>
            @php
                $alertVillages = \App\Models\PestReport::join('plantings', 'pest_reports.planting_id', '=', 'plantings.id')
                    ->selectRaw('plantings.location_name as village, COUNT(DISTINCT pest_reports.user_id) as reporter_count')
                    ->where('pest_reports.status', '!=', 'resolved')
                    ->groupBy('plantings.location_name')
                    ->get();
                
                $waspadaVillages = $alertVillages->filter(function($v) {
                    return $v->reporter_count >= 3;
                });
            @endphp

            @if($waspadaVillages->count() > 0)
                <div class="space-y-2 max-h-[140px] overflow-y-auto pr-1">
                    @foreach($waspadaVillages as $v)
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 flex gap-2.5 items-start">
                            <span class="text-amber-500 shrink-0 text-base mt-0.5">⚠️</span>
                            <div>
                                <p class="font-bold text-xs text-amber-800">Desa {{ $v->village }} (Waspada)</p>
                                <p class="text-[10px] text-amber-700 mt-0.5 leading-normal">
                                    Terdapat {{ $v->reporter_count }} pelapor hama aktif. Direkomendasikan pembagian **Pestisida Nabati Gratis**.
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3.5 flex gap-2.5 items-start">
                    <span class="text-emerald-500 shrink-0 text-base mt-0.5">✅</span>
                    <div>
                        <p class="font-bold text-xs text-emerald-800">Semua Lahan Aman</p>
                        <p class="text-[10px] text-emerald-600 mt-0.5 leading-relaxed">
                            Belum ada wilayah berstatus **Waspada (≥ 3 pelapor)**. Rekomendasi pestisida gratis otomatis muncul di sini jika serangan hama meningkat.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Recent Data Section -->
<section class="mb-8">
    <div class="bg-white rounded-premium shadow-premium p-6 border border-slate-100 flex flex-col max-h-[400px]">
        <div class="flex items-center justify-between mb-4 shrink-0">
            <div>
                <h3 class="font-bold text-slate-800 text-base leading-none">Pendaftaran Petani Terbaru</h3>
                <span class="text-slate-400 text-xs mt-1 block">Petani yang baru terdaftar di sistem PADIKU</span>
            </div>
            <a href="{{ route('dashboard.farmers') }}" class="text-xs font-bold text-emerald-700 hover:underline">Lihat Semua Data Petani</a>
        </div>
        <div class="flex-1 overflow-y-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 font-bold border-b border-slate-50 pb-2">
                        <th class="pb-2">Nama Petani</th>
                        <th class="pb-2">Kecamatan</th>
                        <th class="pb-2">Luas Lahan</th>
                        <th class="pb-2 text-right">Status Akun</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentFarmers as $farmer)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 font-semibold text-slate-700 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px]">
                                    {{ strtoupper(substr($farmer->name, 0, 1)) }}
                                </div>
                                {{ $farmer->name }}
                            </td>
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
                            <td class="py-3 font-semibold text-slate-700 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px]">A</div>
                                Asep Setiawan
                            </td>
                            <td class="py-3 text-slate-500">Klari</td>
                            <td class="py-3 font-medium text-slate-700">4.5 Ha</td>
                            <td class="py-3 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 font-semibold text-slate-700 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px]">B</div>
                                Budi Rahardjo
                            </td>
                            <td class="py-3 text-slate-500">Rawamerta</td>
                            <td class="py-3 font-medium text-slate-700">3.2 Ha</td>
                            <td class="py-3 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700">Aktif</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3 font-semibold text-slate-700 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-[10px]">C</div>
                                Cecep Mulyana
                            </td>
                            <td class="py-3 text-slate-500">Telukjambe Barat</td>
                            <td class="py-3 font-medium text-slate-700">0.0 Ha</td>
                            <td class="py-3 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-700">Baru</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

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