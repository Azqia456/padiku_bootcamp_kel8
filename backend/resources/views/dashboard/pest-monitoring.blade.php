@php $activeMenu = 'pest'; @endphp
@extends('layouts.admin')

@section('title', 'Monitoring Hama')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .map-wrapper {
            position: relative;
            width: 100%;
            height: 500px;
            background: #f0f0f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        .legend {
            background: rgba(255, 255, 255, 0.95);
            padding: 12px;
            line-height: 24px;
            color: #333;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-size: 13px;
        }
        .legend h4 {
            margin: 0 0 8px 0;
            font-size: 14px;
            font-weight: bold;
            color: #111;
        }
        .legend i {
            width: 16px;
            height: 16px;
            float: left;
            margin-right: 10px;
            margin-top: 4px;
            opacity: 0.85;
            border-radius: 3px;
        }
    </style>
@endpush

@section('content')
<x-page-banner
    title="Monitoring Hama"
    subtitle="Pantau laporan serangan hama dari petani"
    image="bg_hama.jpg"
/>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <div class="lg:col-span-3">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <h2 class="font-bold text-hijau-utama mb-3 text-sm">Peta Sebaran Hama — Kabupaten Karawang</h2>
            <div class="map-wrapper" id="mapWrapper" style="cursor: default;">
                <div id="map" style="width: 100%; height: 100%; z-index: 1;"></div>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Total Laporan</p>
            <p class="text-3xl font-bold text-red-600">{{ $pestReports->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-500">
            <p class="text-sm text-gray-500">Laporan Aktif</p>
            <p class="text-3xl font-bold text-orange-600">{{ $activeCount }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500">Wilayah Terdampak</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ $pestData->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Petani Terdampak</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ $pestData->sum('affected_farmers') }}</p>
        </div>
    </div>
</div>

@if($pestData->count() > 0)
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-hijau-utama">Detail Sebaran Hama per Wilayah</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold">Wilayah</th>
                    <th class="text-left px-6 py-3 font-semibold">Tingkat Serangan</th>
                    <th class="text-left px-6 py-3 font-semibold">Jenis Hama</th>
                    <th class="text-left px-6 py-3 font-semibold">Petani Terdampak</th>
                    <th class="text-left px-6 py-3 font-semibold">Luas Lahan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pestData as $data)
                    <tr class="border-t border-gray-50 hover:bg-green-50/30">
                        <td class="px-6 py-3 font-medium">{{ $data->district }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $data->severity_percentage < 25 ? 'bg-green-100 text-green-700' : 
                                   ($data->severity_percentage < 50 ? 'bg-yellow-100 text-yellow-700' : 
                                   ($data->severity_percentage < 75 ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700')) }}">
                                {{ number_format($data->severity_percentage, 1) }}%
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">{{ $data->common_pest->pest_type ?? '-' }}</td>
                        <td class="px-6 py-3 text-hijau-utama font-semibold">{{ $data->affected_farmers }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ number_format($data->affected_area, 2) }} Ha</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

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

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const map = L.map('map').setView([-6.3224, 107.3376], 10);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Data jumlah pelapor per desa dari database (location_name → jumlah user unik)
        const villageReportCounts = @json($villageReportCounts);

        /**
         * Tentukan status hama secara acak untuk kebutuhan demo/project,
         * KECUALI desa Cikampek Pusaka yang Wajib Hijau (Aman).
         */
        function getVillageStatus(villageName) {
            const nameNorm = villageName.toLowerCase().replace(/\s+/g, '').trim();
            
            // Ambil jumlah pelapor asli dari database jika ada
            let count = 0;
            for (const [key, val] of Object.entries(villageReportCounts)) {
                if (key.toLowerCase().replace(/\s+/g, '').trim() === nameNorm) {
                    count = val;
                    break;
                }
            }

            // Cikampek Pusaka wajib Hijau (Aman) untuk awal demo jika count = 0
            if (nameNorm === 'cikampekpusaka' && count === 0) {
                return { color: '#00B159', name: 'Aman', count: count };
            }

            // Tentukan status dan warna secara dinamis berdasarkan jumlah pelapor
            if (count < 3) {
                return { color: '#00B159', name: 'Aman', count: count };
            } else if (count >= 3 && count < 6) {
                return { color: '#FFC425', name: 'Waspada', count: count };
            } else if (count >= 6 && count < 10) {
                return { color: '#F37735', name: 'Tinggi', count: count };
            } else {
                return { color: '#D11141', name: 'Sangat Tinggi', count: count };
            }
        }

        // Memuat file GeoJSON
        fetch("{{ asset('geojson/karawang-desa.json') }}")
            .then(res => res.json())
            .then(function(geojson) {
                L.geoJSON(geojson, {
                    style: function(feature) {
                        const namaDesa = feature.properties.NAMOBJ || feature.properties.DESA || feature.properties.NAME_4 || '';
                        const status = getVillageStatus(namaDesa);
                        feature.properties.statusHama  = status.name;
                        feature.properties.warnaHama   = status.color;
                        feature.properties.jumlahLapor = status.count;

                        return {
                            fillColor:   status.color,
                            weight:      1,
                            opacity:     1,
                            color:       'white',
                            fillOpacity: 0.7
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const namaDesa   = feature.properties.NAMOBJ || feature.properties.DESA || feature.properties.NAME_4 || 'Desa';
                        const kecamatan  = feature.properties.WADMKC || feature.properties.KECAMATAN || feature.properties.NAME_3 || 'Kecamatan';
                        const jumlah     = feature.properties.jumlahLapor || 0;
                        const warna      = feature.properties.warnaHama;
                        const statusNama = feature.properties.statusHama;

                        layer.bindPopup(
                            `<div style="font-size: 13px;">` +
                            `<b style="color: #333; font-size: 14px;">${namaDesa}</b><br>` +
                            `<span style="color: #666;">Kec. ${kecamatan}</span>` +
                            `<hr style="margin: 5px 0;">` +
                            `<b>Status Hama:</b> <span style="color: ${warna}; font-weight: bold;">${statusNama}</span><br>` +
                            `<b>Pelapor:</b> ${jumlah} petani` +
                            `</div>`
                        );
                    }
                }).addTo(map);
            }).catch(function(error) {
                console.error("Gagal memuat GeoJSON:", error);
                document.getElementById('map').innerHTML = "<div style='padding: 20px; text-align: center; color: red;'>Gagal memuat data peta (pastikan karawang-desa.json ada di public/geojson/)</div>";
            });

        // Kontrol Legenda Peta
        const legend = L.control({position: 'bottomleft'});
        legend.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'info legend');
            div.innerHTML += '<h4>Tingkat Serangan Hama</h4>';
            div.innerHTML += '<i style="background: #00B159"></i> Aman<br>';
            div.innerHTML += '<i style="background: #FFC425"></i> Waspada<br>';
            div.innerHTML += '<i style="background: #F37735"></i> Tinggi<br>';
            div.innerHTML += '<i style="background: #D11141"></i> Sangat Tinggi<br>';
            return div;
        };
        legend.addTo(map);
    });
</script>
@endpush

