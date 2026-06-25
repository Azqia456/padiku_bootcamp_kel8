@php $activeMenu = 'dashboard'; @endphp
@extends('layouts.admin')

@section('title', 'Analisis Data')

@section('content')
<x-page-banner
    title="Analisis Data"
    subtitle="Analisis mendalam data pertanian Karawang"
/>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-hijau-utama mb-4">Jenis Hama</h3>
        @forelse($pestTypes as $pest)
            <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
                <span class="text-gray-700">{{ $pest->pest_type }}</span>
                <span class="font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full text-sm">{{ $pest->count }}</span>
            </div>
        @empty
            <x-empty-state message="Belum ada data hama" />
        @endforelse
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-hijau-utama mb-4">Tingkat Keparahan</h3>
        @forelse($severityDistribution as $severity)
            @php $maxSev = $severityDistribution->max('count') ?: 1; $pct = ($severity->count / $maxSev) * 100; @endphp
            <div class="mb-3">
                <div class="flex justify-between text-sm mb-1">
                    <span class="capitalize text-gray-700">{{ $severity->severity }}</span>
                    <span class="font-bold">{{ $severity->count }}</span>
                </div>
                <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-orange-400 rounded-full" style="width: {{ $pct }}%"></div>
                </div>
            </div>
        @empty
            <x-empty-state message="Belum ada data" />
        @endforelse
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 md:col-span-2">
        <h3 class="font-bold text-hijau-utama mb-4">Varietas Padi</h3>
        @forelse($riceVarieties as $variety)
            <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
                <span class="font-medium text-gray-800">{{ $variety->rice_variety }}</span>
                <div class="text-right text-sm">
                    <span class="font-bold text-hijau-utama">{{ $variety->count }} lahan</span>
                    <span class="text-gray-500 ml-2">{{ number_format($variety->total_area, 2) }} Ha</span>
                </div>
            </div>
        @empty
            <x-empty-state message="Belum ada data varietas" />
        @endforelse
    </div>
</div>
@endsection
