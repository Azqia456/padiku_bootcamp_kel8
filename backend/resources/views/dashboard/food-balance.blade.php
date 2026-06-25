@php $activeMenu = 'food-balance'; @endphp
@extends('layouts.admin')

@section('title', 'Neraca Pangan')

@section('content')
<x-page-banner
    title="Neraca Pangan"
    subtitle="Keseimbangan produksi dan konsumsi pangan Karawang"
    image="Farmers harvesting rice in Vietnam_.jpeg"
/>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border-t-4 border-green-500">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Produksi</p>
        <p class="text-3xl font-bold text-green-600">{{ number_format($totalProduction, 2) }} ton</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-t-4 border-red-400">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Konsumsi</p>
        <p class="text-3xl font-bold text-red-600">{{ number_format($totalConsumption, 2) }} ton</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-t-4 {{ $balance >= 0 ? 'border-green-500' : 'border-red-400' }}">
        <p class="text-sm font-medium text-gray-600 mb-2">Surplus / Defisit</p>
        <p class="text-3xl font-bold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $balance >= 0 ? '+' : '' }}{{ number_format($balance, 2) }} ton
        </p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-6">
    <h2 class="font-bold text-hijau-utama mb-4">Visualisasi Neraca</h2>
    @php
        $total = max($totalProduction + $totalConsumption, 1);
        $prodPct = ($totalProduction / $total) * 100;
        $consPct = ($totalConsumption / $total) * 100;
    @endphp
    <div class="h-8 rounded-full overflow-hidden flex mb-4">
        <div class="bg-green-500 h-full transition-all" style="width: {{ $prodPct }}%"></div>
        <div class="bg-red-400 h-full transition-all" style="width: {{ $consPct }}%"></div>
    </div>
    <div class="flex gap-6 text-sm">
        <div class="flex items-center gap-2"><span class="w-3 h-3 bg-green-500 rounded-full"></span> Produksi ({{ number_format($prodPct, 1) }}%)</div>
        <div class="flex items-center gap-2"><span class="w-3 h-3 bg-red-400 rounded-full"></span> Konsumsi ({{ number_format($consPct, 1) }}%)</div>
    </div>
</div>
@endsection
