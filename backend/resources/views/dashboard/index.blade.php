@php $activeMenu = 'dashboard'; @endphp
@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')
{{-- Hero: Menggunakan Konsep Gambar Ke-1 dengan Efek Kontras yang Jelas --}}
<section class="relative rounded-2xl overflow-hidden mb-8 shadow-xl min-h-[260px] flex items-center">

    <img src="{{ asset('images/bg_db.png') }}" alt="Sawah Karawang" class="absolute inset-0 w-full h-full object-cover">
    
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-transparent"></div>
    
    <div class="relative z-10 p-8 md:p-10 flex items-center gap-6 w-full">
        
        <div class="w-full">
  
        <div class="inline-flex items-center gap-2 bg-white/20 text-[11px] font-bold uppercase tracking-wider text-white px-3.5 py-1.5 rounded-full mb-4 backdrop-blur-md border border-white/20 shadow-sm">
    <span class="w-2 h-2 rounded-full bg-amber-400 shrink-0"></span>
    Dinas Pertanian Karawang
</div>
            
            <h1 class="text-2xl md:text-4xl font-extrabold text-white mb-2 leading-tight drop-shadow-md">
                Kelola Tanam, Panen Lebih Pasti
            </h1>
            
            <p class="text-gray-100 text-sm md:text-base max-w-xl mb-5 drop-shadow">
                Platform digital informasi dan koordinasi usaha tani untuk monitoring pertanian Karawang.
            </p>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('dashboard.map') }}" class="inline-flex items-center gap-2 bg-amber-500 text-gray-900 font-bold py-2.5 px-5 rounded-xl hover:bg-amber-600 transition text-sm shadow-md">
                    Lihat Peta Lahan
                </a>
                <a href="{{ route('dashboard.farmers') }}" class="inline-flex items-center gap-2 bg-white/20 text-white font-semibold py-2.5 px-5 rounded-xl hover:bg-white/30 transition text-sm border border-white/30 backdrop-blur-sm">
                    Manajemen Petani
                </a>
            </div>
        </div>
    </div>
</section>

<section class="mb-8">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-hijau-utama">Ringkasan Data</h2>
        <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
        @php
            $stats = [
                ['label' => 'Total Sawah', 'value' => number_format($totalArea, 2).' Ha', 'color' => 'border-[#0A5C34]', 'bg' => 'bg-green-50', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Total Produksi', 'value' => number_format($totalArea * 5, 0).' ton', 'color' => 'border-[#F2C230]', 'bg' => 'bg-yellow-50', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10L4 17'],
                ['label' => 'Prediksi Produksi', 'value' => number_format($totalArea * 5.2, 0).' ton', 'color' => 'border-[#2E7D32]', 'bg' => 'bg-green-50', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['label' => 'Total Petani', 'value' => $totalFarmers, 'color' => 'border-[#63A52F]', 'bg' => 'bg-green-50', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['label' => 'Laporan Hama', 'value' => $totalPestReports, 'color' => 'border-red-400', 'bg' => 'bg-red-50', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                ['label' => 'Lahan Terdaftar', 'value' => $totalPlantings, 'color' => 'border-[#FFD54F]', 'bg' => 'bg-yellow-50', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
            ];
        @endphp
        @foreach($stats as $stat)
            <div class="stat-card bg-white rounded-xl shadow-sm p-4 border-l-4 {{ $stat['color'] }}">
                <div class="w-9 h-9 {{ $stat['bg'] }} rounded-lg flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-hijau-utama" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
                <p class="text-gray-500 text-xs mb-1">{{ $stat['label'] }}</p>
                <p class="text-lg font-bold text-hijau-utama">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>
</section>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
    <div class="xl:col-span-2">
        <h2 class="text-xl font-bold text-hijau-utama mb-5">Akses Cepat</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @php
                $quickLinks = [
                    ['route' => 'dashboard.map', 'title' => 'Peta Lahan', 'desc' => 'Sebaran sawah', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'color' => 'bg-green-100 text-hijau-utama'],
                    ['route' => 'dashboard.plantings', 'title' => 'Monitoring Tanam', 'desc' => 'Data tanam padi', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'bg-emerald-100 text-emerald-700'],
                    ['route' => 'dashboard.pest-monitoring', 'title' => 'Monitoring Hama', 'desc' => 'Laporan hama', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'color' => 'bg-red-100 text-red-600'],
                    ['route' => 'dashboard.fertilizer', 'title' => 'Distribusi Pupuk', 'desc' => 'Jadwal pemupukan', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'color' => 'bg-yellow-100 text-yellow-700'],
                    ['route' => 'dashboard.statistics', 'title' => 'Statistik', 'desc' => 'Produksi bulanan', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'color' => 'bg-green-100 text-hijau-utama'],
                    ['route' => 'dashboard.data-analysis', 'title' => 'Analisis Data', 'desc' => 'Varietas & hama', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'bg-orange-100 text-orange-700'],
                ];
            @endphp
            @foreach($quickLinks as $link)
                <a href="{{ route($link['route']) }}" class="bg-white rounded-xl shadow-sm p-4 hover:shadow-md transition flex items-center gap-3 border border-gray-100">
                    <div class="w-10 h-10 {{ $link['color'] }} rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $link['title'] }}</p>
                        <p class="text-xs text-gray-500">{{ $link['desc'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div>
        <h2 class="text-xl font-bold text-hijau-utama mb-5">Status Tanam</h2>
        <div class="bg-white rounded-xl shadow-sm p-5">
            @forelse($productionByStatus as $status)
                @php
                    $pct = $totalPlantings > 0 ? ($status->count / $totalPlantings) * 100 : 0;
                    $colors = ['planted' => 'bg-green-500', 'growing' => 'bg-emerald-400', 'harvested' => 'bg-yellow-500', 'failed' => 'bg-red-400'];
                    $barColor = $colors[$status->status] ?? 'bg-gray-400';
                @endphp
                <div class="mb-4 last:mb-0">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium capitalize text-gray-700">{{ str_replace('_', ' ', $status->status) }}</span>
                        <span class="text-gray-500">{{ $status->count }} lahan</span>
                    </div>
                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="{{ $barColor }} h-full rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @empty
                <x-empty-state message="Belum ada data tanam" />
            @endforelse
        </div>

        @if($activePestReports > 0)
            <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-semibold text-red-700 text-sm">{{ $activePestReports }} laporan hama aktif</p>
                    <a href="{{ route('dashboard.pest-monitoring') }}" class="text-xs text-red-600 hover:underline mt-1 inline-block">Lihat detail →</a>
                </div>
            </div>
        @endif
    </div>
</div>

<section>
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-hijau-utama">Laporan Hama Terbaru</h2>
        <a href="{{ route('dashboard.pest-monitoring') }}" class="text-sm text-hijau-utama font-medium hover:underline">Semua →</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        @forelse($recentPestReports->take(5) as $report)
            <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-50 last:border-0 hover:bg-green-50/50 transition">
                <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $report->pest_type }}</p>
                    <p class="text-xs text-gray-500">{{ $report->user->name ?? 'Petani' }} · {{ $report->report_date?->format('d M Y') }}</p>
                </div>
                <span class="text-xs font-semibold px-2 py-1 rounded-full
                    {{ in_array($report->severity, ['high', 'critical']) ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($report->severity) }}
                </span>
            </div>
        @empty
            <x-empty-state message="Belum ada laporan hama" />
        @endforelse
    </div>
</section>

@if($totalPlantings == 0)
<section class="mt-6">
    <div class="bg-green-50 border border-green-200 rounded-2xl p-8 text-center">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Database Masih Kosong</h3>
        <p class="text-gray-600 text-sm max-w-md mx-auto">Data akan muncul setelah petani mendaftar melalui aplikasi mobile.</p>
    </div>
</section>
@endif
@endsection