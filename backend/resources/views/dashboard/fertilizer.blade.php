@php $activeMenu = 'fertilizer'; @endphp
@extends('layouts.admin')

@section('title', 'Distribusi Pupuk')

@section('content')
<x-page-banner
    title="Distribusi Pupuk"
    subtitle="Kelola jadwal dan distribusi pupuk ke petani"
    image="complementary.webp"
/>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#0A5C34]">
        <p class="text-sm text-gray-500">Total Jadwal</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $schedules->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#F2C230]">
        <p class="text-sm text-gray-500">Menunggu Distribusi</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $schedules->where('status', 'pending')->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#63A52F]">
        <p class="text-sm text-gray-500">Total Pupuk (kg)</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ number_format($schedules->sum('amount_kg'), 0) }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-hijau-utama">Jadwal Distribusi Pupuk</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold">Petani</th>
                    <th class="text-left px-6 py-3 font-semibold">Jenis Pupuk</th>
                    <th class="text-left px-6 py-3 font-semibold">Jumlah</th>
                    <th class="text-left px-6 py-3 font-semibold">Jadwal</th>
                    <th class="text-left px-6 py-3 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                    <tr class="border-t border-gray-50 hover:bg-green-50/30 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $schedule->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $schedule->fertilizer_type }}</td>
                        <td class="px-6 py-4 font-semibold text-hijau-utama">{{ number_format($schedule->amount_kg, 1) }} kg</td>
                        <td class="px-6 py-4 text-gray-600">{{ $schedule->scheduled_date?->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'applied' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700'];
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColors[$schedule->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><x-empty-state message="Belum ada jadwal distribusi pupuk" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
