@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Analisis Data</h2>
                <p class="mt-1 text-sm text-gray-600">Analisis mendalam data pertanian</p>
            </div>
            
            <div class="bg-gray-50 bg-opacity-75 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Jenis Hama</h3>
                        @foreach($pestTypes as $pest)
                            <div class="flex justify-between py-2 border-b">
                                <span>{{ $pest->pest_type }}</span>
                                <span class="font-bold">{{ $pest->count }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Distribusi Tingkat Keparahan</h3>
                        @foreach($severityDistribution as $severity)
                            <div class="flex justify-between py-2 border-b">
                                <span>{{ ucfirst($severity->severity) }}</span>
                                <span class="font-bold">{{ $severity->count }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
                        <h3 class="font-bold text-gray-900 mb-4">Varietas Padi</h3>
                        @foreach($riceVarieties as $variety)
                            <div class="flex justify-between py-2 border-b">
                                <span>{{ $variety->rice_variety }}</span>
                                <div class="text-right">
                                    <span class="font-bold">{{ $variety->count }} lahan</span>
                                    <span class="text-gray-500 ml-2">{{ number_format($variety->total_area, 2) }} Ha</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
