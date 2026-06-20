@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Dashboard Monitoring Karawang</h2>
                        <p class="mt-1 text-sm text-gray-600">Platform Digital Informasi dan Koordinasi Usaha Tani</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 bg-opacity-75">
                <div class="p-6">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Lahan</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalArea, 2) }} Ha</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Petani</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalFarmers }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-red-100 text-red-600">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Laporan Hama Aktif</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $activePestReports }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('dashboard.map') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-green-100 text-green-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Peta Pertanian</p>
                                    <p class="text-sm text-gray-500">Lihat sebaran lahan</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('dashboard.statistics') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Statistik Produksi</p>
                                    <p class="text-sm text-gray-500">Data produksi padi</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('dashboard.food-balance') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-yellow-100 text-yellow-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Neraca Pangan</p>
                                    <p class="text-sm text-gray-500">Keseimbangan pangan</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('dashboard.data-analysis') }}" class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-purple-100 text-purple-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Analisis Data</p>
                                    <p class="text-sm text-gray-500">Analisis mendalam</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    @if($totalPlantings == 0)
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-900">Belum ada data</p>
                                <p class="text-sm text-gray-600">Database masih kosong. Silakan tambahkan data melalui API atau mobile app.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
