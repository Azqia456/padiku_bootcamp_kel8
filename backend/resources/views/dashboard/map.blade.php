@php $activeMenu = 'map'; @endphp
@extends('layouts.admin')

@section('title', 'Monitoring Lahan')

@section('content')
<x-page-banner
    title="Peta Pertanian Karawang"
    subtitle="Sebaran lahan pertanian di seluruh wilayah Karawang"
    image="bg.jpg"
/>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
        <div class="bg-gray-100 rounded-xl h-80 flex items-center justify-center relative overflow-hidden">
            <img src="{{ asset('images/bg_db.png') }}" alt="Peta lahan" class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="relative text-center z-10 px-4">
                <svg class="w-14 h-14 text-hijau-utama mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                <p class="text-gray-700 font-medium">Peta interaktif akan ditampilkan di sini</p>
                <p class="text-sm text-gray-500 mt-1">{{ $plantings->count() }} titik lahan terdaftar</p>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#0A5C34]">
            <p class="text-sm text-gray-500">Total Titik Lahan</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ $plantings->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#F2C230]">
            <p class="text-sm text-gray-500">Total Luas</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ number_format($plantings->sum('area_hectares'), 2) }} Ha</p>
        </div>
    </div>
</div>

@if($plantings->count() > 0)
<div class="mt-6 bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-hijau-utama">Daftar Lahan Terdaftar</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold">Lokasi</th>
                    <th class="text-left px-6 py-3 font-semibold">Petani</th>
                    <th class="text-left px-6 py-3 font-semibold">Luas</th>
                    <th class="text-left px-6 py-3 font-semibold">Koordinat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plantings as $planting)
                    <tr class="border-t border-gray-50 hover:bg-green-50/30">
                        <td class="px-6 py-3 font-medium">{{ $planting->location_name }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $planting->user->name ?? '-' }}</td>
                        <td class="px-6 py-3 text-hijau-utama font-semibold">{{ number_format($planting->area_hectares, 2) }} Ha</td>
                        <td class="px-6 py-3 text-gray-500 text-xs">{{ $planting->latitude }}, {{ $planting->longitude }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
    <div class="mt-6 bg-white rounded-xl shadow-sm"><x-empty-state message="Belum ada lahan terdaftar" /></div>
@endif
@endsection
