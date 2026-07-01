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

<!-- HARVEST CALENDAR SECTION -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-emerald-50/30">
        <div>
            <h2 class="font-bold text-hijau-utama text-lg flex items-center gap-2">
                <span>🗓️</span> Kalender Prediksi Panen
            </h2>
            <p class="text-xs text-slate-500 mt-1">
                Visualisasi jadwal panen. Tanggal berwarna merah menandakan potensi <span class="font-bold text-red-600">panen serempak</span> di kecamatan yang sama.
            </p>
        </div>
    </div>
    <div class="p-6">
        <div id="harvestCalendar" class="min-h-[500px]"></div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-hijau-utama">Data Lahan & Tanam</h2>
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
                    <th class="text-left px-6 py-3 font-semibold">Estimasi Panen</th>
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
                        <td class="px-6 py-4 font-semibold {{ $planting->expected_harvest_date && $planting->expected_harvest_date->isPast() ? 'text-red-500' : 'text-emerald-600' }}">
                            {{ $planting->expected_harvest_date?->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColors[$planting->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($planting->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><x-empty-state message="Belum ada data tanam" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<style>
    .fc-event { cursor: pointer; border: none; background: transparent; }
    .fc-day-today { background: #f0fdf4 !important; }
    .fc-toolbar-title { font-size: 1.15rem !important; font-weight: 800; color: #0A5C34; }
    .fc-button-primary {
        background-color: #0A5C34 !important;
        border-color: #0A5C34 !important;
        font-weight: bold !important;
        text-transform: capitalize !important;
    }
    .fc-button-primary:hover {
        background-color: #053b20 !important;
        border-color: #053b20 !important;
    }
    .fc-daygrid-day-number { color: #475569; font-weight: 600; font-size: 12px; }
    .fc-col-header-cell-cushion { color: #1e293b; font-weight: 700; text-transform: uppercase; font-size: 11px; padding: 8px !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>
<script>
    // Helper function to get ISO Week String (YYYY-Www)
    function getWeekString(dateString) {
        var d = new Date(dateString);
        d.setHours(0, 0, 0, 0);
        d.setDate(d.getDate() + 4 - (d.getDay() || 7));
        var yearStart = new Date(d.getFullYear(), 0, 1);
        var weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
        return d.getFullYear() + '-W' + weekNo;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('harvestCalendar');
        var plantingsData = @json($plantings);
        
        var events = [];
        var weekCounts = {};
        
        // Menghitung jumlah panen di minggu dan kecamatan yang sama (untuk deteksi serempak)
        plantingsData.forEach(function(p) {
            if (!p.expected_harvest_date) return;
            var weekStr = getWeekString(p.expected_harvest_date);
            var district = p.user ? p.user.district : 'Unknown';
            var key = weekStr + '_' + district;
            weekCounts[key] = (weekCounts[key] || 0) + 1;
        });

        plantingsData.forEach(function(p) {
            var userName = p.user ? p.user.name : 'Anonim';
            var district = p.user ? p.user.district : 'Unknown';

            // 1. Event Tanggal Tanam
            if (p.planting_date) {
                var plantingDateStr = p.planting_date.substring(0, 10);
                events.push({
                    title: '🌱 Tanam: ' + userName,
                    start: plantingDateStr,
                    allDay: true,
                    extendedProps: {
                        bgColorClass: 'bg-green-50 text-green-700 ring-green-200',
                        location: p.location_name,
                        district: district
                    }
                });
            }

            // 2. Event Estimasi Panen
            if (p.expected_harvest_date) {
                var harvestDateStr = p.expected_harvest_date.substring(0, 10);
                var weekStr = getWeekString(p.expected_harvest_date);
                var key = weekStr + '_' + district;
                
                var isConflict = weekCounts[key] >= 2;
                var bgColor = isConflict ? 'bg-red-50 text-red-700 ring-red-200' : 'bg-yellow-50 text-yellow-700 ring-yellow-200';
                var icon = isConflict ? '⚠️ Panen: ' : '🌾 Panen: ';
                
                events.push({
                    title: icon + userName,
                    start: harvestDateStr,
                    allDay: true,
                    extendedProps: {
                        bgColorClass: bgColor,
                        location: p.location_name,
                        district: district
                    }
                });
            }
        });

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            initialView: 'dayGridMonth',
            height: 'auto',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: events,
            eventContent: function(arg) {
                let bgColor = arg.event.extendedProps.bgColorClass;
                return {
                    html: '<div class="px-1.5 py-1 text-[10px] truncate rounded font-bold ' + bgColor + ' ring-1 mb-0.5 transition hover:scale-[1.02]" title="' + arg.event.title + ' (' + arg.event.extendedProps.district + ')">' + arg.event.title + '</div>'
                };
            }
        });
        calendar.render();
    });
</script>
@endpush
