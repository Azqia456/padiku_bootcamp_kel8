@php $activeMenu = 'dashboard'; @endphp
@extends('layouts.admin')

@section('title', 'Statistik Produksi')

@section('content')
<x-page-banner
    title="Statistik Produksi"
    subtitle="Data produksi padi per bulan di Karawang"
/>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-bold text-hijau-utama mb-4">Produksi Bulanan</h2>
        @forelse($monthlyProduction as $prod)
            @php $maxArea = $monthlyProduction->max('total_area') ?: 1; $pct = ($prod->total_area / $maxArea) * 100; @endphp
            <div class="mb-3">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">{{ \Carbon\Carbon::create($prod->year, $prod->month)->format('M Y') }}</span>
                    <span class="font-semibold text-hijau-utama">{{ number_format($prod->total_area, 2) }} Ha · {{ $prod->count }} lahan</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#0A5C34] to-[#63A52F] rounded-full" style="width: {{ $pct }}%"></div>
                </div>
            </div>
        @empty
            <x-empty-state message="Belum ada data produksi" />
        @endforelse
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-bold text-hijau-utama mb-4">Tren Laporan Hama</h2>
        @forelse($pestReportTrends as $trend)
            @php $maxCount = $pestReportTrends->max('count') ?: 1; $pct = ($trend->count / $maxCount) * 100; @endphp
            <div class="mb-3">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">{{ \Carbon\Carbon::create($trend->year, $trend->month)->format('M Y') }}</span>
                    <span class="font-semibold text-red-600">{{ $trend->count }} laporan</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-red-400 to-orange-400 rounded-full" style="width: {{ $pct }}%"></div>
                </div>
            </div>
        @empty
            <x-empty-state message="Belum ada data laporan hama" />
        @endforelse
    </div>
</div>
@endsection
