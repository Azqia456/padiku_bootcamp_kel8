@php $activeMenu = 'farmers'; @endphp
@extends('layouts.admin')

@section('title', 'Manajemen Petani')

@section('content')
<x-page-banner
    title="Manajemen Petani"
    subtitle="Kelola data petani terdaftar di wilayah Karawang"
    image="Farmers harvesting rice in Vietnam_.jpeg"
/>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#0A5C34]">
        <p class="text-sm text-gray-500">Total Petani</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $farmers->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#F2C230]">
        <p class="text-sm text-gray-500">Petani Aktif Tanam</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $farmers->where('plantings_count', '>', 0)->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#63A52F]">
        <p class="text-sm text-gray-500">Kecamatan Terdaftar</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $farmers->pluck('district')->unique()->filter()->count() }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-bold text-hijau-utama">Daftar Petani</h2>
        <span class="text-sm text-gray-500">{{ $farmers->count() }} petani</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold">Nama</th>
                    <th class="text-left px-6 py-3 font-semibold">Email</th>
                    <th class="text-left px-6 py-3 font-semibold">Telepon</th>
                    <th class="text-left px-6 py-3 font-semibold">Kecamatan</th>
                    <th class="text-left px-6 py-3 font-semibold">Lahan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($farmers as $farmer)
                    <tr class="border-t border-gray-50 hover:bg-green-50/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-emas-utama rounded-full flex items-center justify-center text-hijau-utama font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($farmer->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $farmer->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $farmer->email }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $farmer->phone ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $farmer->district ?? 'Belum diisi' }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-hijau-utama">{{ $farmer->plantings_count }} lahan</td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-empty-state message="Belum ada petani terdaftar" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
