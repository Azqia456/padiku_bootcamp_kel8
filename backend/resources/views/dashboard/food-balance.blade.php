@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Neraca Pangan</h2>
                <p class="mt-1 text-sm text-gray-600">Keseimbangan produksi dan konsumsi pangan</p>
            </div>
            
            <div class="bg-gray-50 bg-opacity-75 p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <p class="text-sm font-medium text-gray-600">Total Produksi</p>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($totalProduction, 2) }} ton</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <p class="text-sm font-medium text-gray-600">Total Konsumsi</p>
                        <p class="text-3xl font-bold text-red-600">{{ number_format($totalConsumption, 2) }} ton</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <p class="text-sm font-medium text-gray-600">Surplus/Defisit</p>
                        <p class="text-3xl font-bold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $balance >= 0 ? '+' : '' }}{{ number_format($balance, 2) }} ton
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
