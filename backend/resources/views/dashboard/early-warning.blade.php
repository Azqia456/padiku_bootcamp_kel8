@php $activeMenu = 'early-warning'; @endphp
@extends('layouts.admin')

@section('title', 'Early Warning')

@section('content')
<x-page-banner
    title="Early Warning System"
    subtitle="Peringatan dini serangan hama dan waktu panen"
    overlay="from-orange-900/80 to-[#0A5C34]/60"
/>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-red-50 border border-red-200 rounded-xl p-5">
        <p class="text-sm text-red-600">Hama Kritis</p>
        <p class="text-2xl font-bold text-red-700">{{ $criticalPests->count() }}</p>
    </div>
    <div class="bg-orange-50 border border-orange-200 rounded-xl p-5">
        <p class="text-sm text-orange-600">Notifikasi Peringatan</p>
        <p class="text-2xl font-bold text-orange-700">{{ $recentNotifications->count() }}</p>
    </div>
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">
        <p class="text-sm text-yellow-700">Panen 14 Hari Lagi</p>
        <p class="text-2xl font-bold text-yellow-800">{{ $upcomingHarvests->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-red-100 bg-red-50">
            <h2 class="font-bold text-red-700">Peringatan Hama Kritis</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($criticalPests as $pest)
                <div class="px-6 py-4 hover:bg-red-50/30 transition">
                    <div class="flex justify-between items-start gap-3">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $pest->pest_type }}</p>
                            <p class="text-sm text-gray-500">{{ $pest->user->name ?? 'Petani' }} · {{ $pest->planting->location_name ?? 'Lahan' }}</p>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 bg-red-100 text-red-700 rounded-full shrink-0">{{ ucfirst($pest->severity) }}</span>
                    </div>
                </div>
            @empty
                <x-empty-state message="Tidak ada peringatan hama kritis" />
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-yellow-100 bg-yellow-50">
            <h2 class="font-bold text-yellow-800">Estimasi Panen Mendekat</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($upcomingHarvests as $harvest)
                <div class="px-6 py-4 hover:bg-yellow-50/30 transition flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $harvest->location_name }}</p>
                        <p class="text-sm text-gray-500">{{ $harvest->user->name ?? 'Petani' }} · {{ $harvest->rice_variety }}</p>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <p class="text-sm font-bold text-yellow-700">{{ $harvest->expected_harvest_date?->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ number_format($harvest->area_hectares, 2) }} Ha</p>
                    </div>
                </div>
            @empty
                <x-empty-state message="Tidak ada panen dalam 14 hari ke depan" />
            @endforelse
        </div>
    </div>
</div>

@if($recentNotifications->count() > 0)
    <div class="mt-6 bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-hijau-utama">Notifikasi Peringatan</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($recentNotifications as $notif)
                <div class="px-6 py-4">
                    <p class="font-medium text-gray-800">{{ $notif->title }}</p>
                    <p class="text-sm text-gray-500">{{ $notif->message }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->format('d M Y, H:i') }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
