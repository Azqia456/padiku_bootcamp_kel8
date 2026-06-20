@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Peta Pertanian Karawang</h2>
                <p class="mt-1 text-sm text-gray-600">Sebaran lahan pertanian di seluruh wilayah Karawang</p>
            </div>
            
            <div class="bg-gray-50 bg-opacity-75 p-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600">Peta pertanian akan ditampilkan di sini.</p>
                    <p class="text-sm text-gray-500 mt-2">Total {{ $plantings->count() }} titik lahan terdaftar</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
