@php $activeMenu = 'pest'; @endphp
@extends('layouts.admin')

@section('title', 'Monitoring Hama')

@section('content')
<x-page-banner
    title="Monitoring Hama"
    subtitle="Pantau laporan serangan hama dari petani"
    overlay="from-red-900/80 to-[#0A5C34]/60"
/>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-400">
        <p class="text-sm text-gray-500">Total Laporan</p>
        <p class="text-3xl font-bold text-red-600">{{ $pestReports->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-400">
        <p class="text-sm text-gray-500">Laporan Aktif</p>
        <p class="text-3xl font-bold text-orange-600">{{ $activeCount }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-400">
        <p class="text-sm text-gray-500">Sudah Ditangani</p>
        <p class="text-3xl font-bold text-green-600">{{ $pestReports->where('status', 'resolved')->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-hijau-utama">Daftar Laporan Hama</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold">Jenis Hama</th>
                        <th class="text-left px-6 py-3 font-semibold">Petani</th>
                        <th class="text-left px-6 py-3 font-semibold">Tingkat</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                        <th class="text-left px-6 py-3 font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pestReports as $report)
                        <tr class="border-t border-gray-50 hover:bg-red-50/20 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $report->pest_type }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $report->user->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                    {{ in_array($report->severity, ['high', 'critical']) ? 'bg-red-100 text-red-700' : ($report->severity === 'medium' ? 'bg-orange-100 text-orange-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($report->severity) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $report->status === 'resolved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $report->report_date?->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><x-empty-state message="Belum ada laporan hama" /></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="font-bold text-hijau-utama mb-3">Tingkat Keparahan</h3>
        @forelse($severityStats as $stat)
            <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                <span class="text-sm capitalize text-gray-600">{{ $stat->severity }}</span>
                <span class="font-bold text-hijau-utama">{{ $stat->count }}</span>
            </div>
        @empty
            <p class="text-gray-500 text-sm text-center py-4">Belum ada data</p>
        @endforelse
    </div>
</div>
@endsection
