@php $activeMenu = 'plantings'; @endphp
@extends('layouts.admin')

@section('title', 'Monitoring Tanam')

@section('content')
<x-page-banner
    title="Monitoring Tanam"
    subtitle="Pantau seluruh data tanam padi di Karawang"
    image="download.webp"
/>

<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#0A5C34]">
        <p class="text-sm text-gray-500">Total Lahan</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $plantings->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#2E7D32]">
        <p class="text-sm text-gray-500">Total Luas</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ number_format($plantings->sum('area_hectares'), 2) }} Ha</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#F2C230]">
        <p class="text-sm text-gray-500">Sedang Tumbuh</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $plantings->whereIn('status', ['planted', 'growing'])->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#FFD54F]">
        <p class="text-sm text-gray-500">Sudah Panen</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $plantings->where('status', 'harvested')->count() }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-hijau-utama">Data Tanam Padi</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold">Lokasi</th>
                    <th class="text-left px-6 py-3 font-semibold">Petani</th>
                    <th class="text-left px-6 py-3 font-semibold">Varietas</th>
                    <th class="text-left px-6 py-3 font-semibold">Luas</th>
                    <th class="text-left px-6 py-3 font-semibold">Tgl Tanam</th>
                    <th class="text-left px-6 py-3 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plantings as $planting)
                    @php
                        $statusColors = [
                            'planted' => 'bg-blue-100 text-blue-700',
                            'growing' => 'bg-green-100 text-green-700',
                            'harvested' => 'bg-yellow-100 text-yellow-700',
                            'failed' => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <tr class="border-t border-gray-50 hover:bg-green-50/30 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $planting->location_name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $planting->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $planting->rice_variety ?? '-' }}</td>
                        <td class="px-6 py-4 font-semibold text-hijau-utama">{{ number_format($planting->area_hectares, 2) }} Ha</td>
                        <td class="px-6 py-4 text-gray-600">{{ $planting->planting_date?->format('d M Y') ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColors[$planting->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($planting->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><x-empty-state message="Belum ada data tanam" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
