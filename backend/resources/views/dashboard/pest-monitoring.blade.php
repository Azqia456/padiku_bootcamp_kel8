@php $activeMenu = 'pest'; @endphp
@extends('layouts.admin')

@section('title', 'Monitoring Hama')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #pestMap {
        height: 600px;
        width: 100%;
        border: 2px solid #333;
        background: #f5f5f5;
    }
    .map-container {
        position: relative;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .map-title {
        position: absolute;
        top: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255,255,255,0.98);
        padding: 12px 24px;
        border: 2px solid #333;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        color: #333;
        z-index: 1001;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        pointer-events: none;
    }
    .map-subtitle {
        font-size: 12px;
        font-weight: normal;
        color: #666;
        margin-top: 4px;
    }
    .legend-box {
        position: absolute;
        top: 30px;
        left: 30px;
        background: rgba(255,255,255,0.98);
        padding: 15px;
        border: 2px solid #333;
        border-radius: 4px;
        z-index: 1001;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        max-width: 280px;
        pointer-events: none;
    }
    .legend-title {
        font-weight: bold;
        font-size: 12px;
        margin-bottom: 10px;
        color: #333;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
    }
    .legend-matrix {
        display: grid;
        grid-template-columns: 80px 1fr;
        gap: 8px;
        font-size: 11px;
    }
    .legend-row {
        display: contents;
    }
    .legend-label {
        color: #333;
        font-weight: 500;
    }
    .legend-colors {
        display: flex;
        gap: 4px;
    }
    .legend-color {
        width: 20px;
        height: 20px;
        border: 1px solid #333;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 9px;
        font-weight: bold;
        color: #333;
    }
    .scale-bar {
        position: absolute;
        bottom: 30px;
        right: 30px;
        background: rgba(255,255,255,0.98);
        padding: 8px 12px;
        border: 2px solid #333;
        border-radius: 4px;
        z-index: 1001;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        pointer-events: none;
    }
    .scale-line {
        height: 3px;
        background: #333;
        margin: 5px 0;
    }
    .scale-text {
        font-size: 10px;
        color: #333;
        text-align: center;
    }
    .compass {
        position: absolute;
        bottom: 30px;
        left: 30px;
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.98);
        border: 2px solid #333;
        border-radius: 50%;
        z-index: 1001;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }
    .compass-inner {
        width: 40px;
        height: 40px;
        position: relative;
    }
    .compass-n {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        font-size: 14px;
        font-weight: bold;
        color: #d32f2f;
    }
    .compass-s {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }
    .compass-e {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }
    .compass-w {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 4px;
        box-shadow: 0 3px 14px rgba(0,0,0,0.4);
    }
    .leaflet-popup-content {
        font-size: 12px;
        line-height: 1.4;
    }
    .leaflet-container {
        font-family: 'Arial', sans-serif;
    }
</style>
@endpush

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

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <div class="lg:col-span-3">
        <div class="map-container">
            <div class="map-title">
                PETA SEBARAN HAMA
                <div class="map-subtitle">KABUPATEN KARAWANG</div>
            </div>
            <div class="legend-box">
                <div class="legend-title">Tingkat Serangan</div>
                <div class="legend-matrix">
                    <div class="legend-row">
                        <div class="legend-label">Aman</div>
                        <div class="legend-colors">
                            <div class="legend-color" style="background: #90EE90;">A1</div>
                        </div>
                    </div>
                    <div class="legend-row">
                        <div class="legend-label">Waspada</div>
                        <div class="legend-colors">
                            <div class="legend-color" style="background: #FFD700;">B1</div>
                            <div class="legend-color" style="background: #FFA500;">B2</div>
                        </div>
                    </div>
                    <div class="legend-row">
                        <div class="legend-label">Tinggi</div>
                        <div class="legend-colors">
                            <div class="legend-color" style="background: #FF6347;">C1</div>
                            <div class="legend-color" style="background: #FF4500;">C2</div>
                        </div>
                    </div>
                    <div class="legend-row">
                        <div class="legend-label">Sangat Tinggi</div>
                        <div class="legend-colors">
                            <div class="legend-color" style="background: #DC143C;">D1</div>
                            <div class="legend-color" style="background: #8B0000;">D2</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="compass">
                <div class="compass-inner">
                    <div class="compass-n">N</div>
                    <div class="compass-s">S</div>
                    <div class="compass-e">E</div>
                    <div class="compass-w">W</div>
                </div>
            </div>
            <div class="scale-bar">
                <div class="scale-line" style="width: 100px;"></div>
                <div class="scale-text">10 km</div>
            </div>
            <div id="pestMap"></div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Total Laporan Hama</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ $pestData->sum('total_reports') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-500">
            <p class="text-sm text-gray-500">Wilayah Terdampak</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ $pestData->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500">Petani Terdampak</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ $pestData->sum('affected_farmers') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Luas Lahan Terdampak</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ number_format($pestData->sum('affected_area'), 2) }} Ha</p>
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
    // Karawang district boundaries (more complex polygon shapes)
    const karawangDistricts = {
        "Karawang Barat": [[-6.32, 107.28], [-6.30, 107.30], [-6.30, 107.32], [-6.32, 107.34], [-6.35, 107.34], [-6.38, 107.32], [-6.38, 107.28], [-6.35, 107.26]],
        "Karawang Timur": [[-6.32, 107.34], [-6.30, 107.36], [-6.30, 107.40], [-6.32, 107.42], [-6.35, 107.42], [-6.38, 107.40], [-6.38, 107.34], [-6.35, 107.34]],
        "Telukjambe Barat": [[-6.28, 107.28], [-6.26, 107.30], [-6.26, 107.32], [-6.28, 107.34], [-6.32, 107.34], [-6.32, 107.28], [-6.30, 107.26]],
        "Telukjambe Timur": [[-6.28, 107.34], [-6.26, 107.36], [-6.26, 107.40], [-6.28, 107.42], [-6.32, 107.42], [-6.32, 107.34], [-6.30, 107.34]],
        "Kotabaru": [[-6.24, 107.28], [-6.22, 107.30], [-6.22, 107.32], [-6.24, 107.34], [-6.28, 107.34], [-6.28, 107.28], [-6.26, 107.26]],
        "Klari": [[-6.24, 107.34], [-6.22, 107.36], [-6.22, 107.40], [-6.24, 107.42], [-6.28, 107.42], [-6.28, 107.34], [-6.26, 107.34]],
        "Cikampek": [[-6.38, 107.42], [-6.36, 107.44], [-6.36, 107.46], [-6.38, 107.48], [-6.44, 107.48], [-6.44, 107.42], [-6.42, 107.40]],
        "Purwasari": [[-6.44, 107.34], [-6.42, 107.36], [-6.42, 107.40], [-6.44, 107.42], [-6.48, 107.42], [-6.48, 107.34], [-6.46, 107.32]],
        "Cilamaya Wetan": [[-6.18, 107.28], [-6.16, 107.30], [-6.16, 107.32], [-6.18, 107.34], [-6.24, 107.34], [-6.24, 107.28], [-6.22, 107.26]],
        "Cilamaya Kulon": [[-6.18, 107.34], [-6.16, 107.36], [-6.16, 107.40], [-6.18, 107.42], [-6.24, 107.42], [-6.24, 107.34], [-6.22, 107.34]],
        "Tempuran": [[-6.14, 107.28], [-6.12, 107.30], [-6.12, 107.32], [-6.14, 107.34], [-6.18, 107.34], [-6.18, 107.28], [-6.16, 107.26]],
        "Jayakerta": [[-6.14, 107.34], [-6.12, 107.36], [-6.12, 107.40], [-6.14, 107.42], [-6.18, 107.42], [-6.18, 107.34], [-6.16, 107.34]],
        "Pedes": [[-6.10, 107.28], [-6.08, 107.30], [-6.08, 107.32], [-6.10, 107.34], [-6.14, 107.34], [-6.14, 107.28], [-6.12, 107.26]],
        "Tirtajaya": [[-6.10, 107.34], [-6.08, 107.36], [-6.08, 107.40], [-6.10, 107.42], [-6.14, 107.42], [-6.14, 107.34], [-6.12, 107.34]],
        "Rawamerta": [[-6.44, 107.28], [-6.42, 107.30], [-6.42, 107.32], [-6.44, 107.34], [-6.48, 107.34], [-6.48, 107.28], [-6.46, 107.26]],
        "Tegalwaru": [[-6.48, 107.28], [-6.46, 107.30], [-6.46, 107.32], [-6.48, 107.34], [-6.52, 107.34], [-6.52, 107.28], [-6.50, 107.26]],
        "Majalaya": [[-6.48, 107.34], [-6.46, 107.36], [-6.46, 107.40], [-6.48, 107.42], [-6.52, 107.42], [-6.52, 107.34], [-6.50, 107.34]],
        "Banyusari": [[-6.52, 107.28], [-6.50, 107.30], [-6.50, 107.32], [-6.52, 107.34], [-6.56, 107.34], [-6.56, 107.28], [-6.54, 107.26]],
        "Jatisari": [[-6.52, 107.34], [-6.50, 107.36], [-6.50, 107.40], [-6.52, 107.42], [-6.56, 107.42], [-6.56, 107.34], [-6.54, 107.34]],
        "Ciampel": [[-6.38, 107.28], [-6.36, 107.30], [-6.36, 107.32], [-6.38, 107.34], [-6.44, 107.34], [-6.44, 107.28], [-6.42, 107.26]]
    };

    // Pest data from server
    const pestData = @json($pestData);

    // Initialize map
    const map = L.map('pestMap').setView([-6.35, 107.35], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Function to get color based on severity with matrix colors
    function getColor(severity) {
        if (severity < 25) return '#90EE90'; // Light Green - Aman (A1)
        if (severity < 50) return '#FFD700'; // Gold - Waspada (B1)
        if (severity < 75) return '#FF6347'; // Tomato - Tinggi (C1)
        return '#DC143C'; // Crimson - Sangat Tinggi (D1)
    }

    // Function to style each district with professional cartography style
    function style(feature) {
        const districtData = pestData.find(d => d.district === feature.properties.name);
        const severity = districtData ? districtData.severity_percentage : 0;
        
        return {
            fillColor: getColor(severity),
            weight: 2,
            opacity: 1,
            color: '#333',
            dashArray: '',
            fillOpacity: 0.8
        };
    }

    // Function to highlight feature
    function highlightFeature(e) {
        const layer = e.target;
        layer.setStyle({
            weight: 4,
            color: '#000',
            dashArray: '',
            fillOpacity: 1
        });
        layer.bringToFront();
    }

    // Function to reset highlight
    function resetHighlight(e) {
        geojson.resetStyle(e.target);
    }

    // Function to show popup
    function onEachFeature(feature, layer) {
        const districtData = pestData.find(d => d.district === feature.properties.name);
        
        if (districtData) {
            const popupContent = `
                <div style="min-width: 200px;">
                    <h3 style="font-weight: bold; margin-bottom: 8px; color: #0A5C34;">${districtData.district}</h3>
                    <div style="margin-bottom: 6px;">
                        <strong>Jenis Hama:</strong> ${districtData.common_pest ? districtData.common_pest.pest_type : '-'}
                    </div>
                    <div style="margin-bottom: 6px;">
                        <strong>Tingkat Serangan:</strong> 
                        <span style="color: ${getColor(districtData.severity_percentage)}; font-weight: bold;">
                            ${districtData.severity_percentage.toFixed(1)}%
                        </span>
                    </div>
                    <div style="margin-bottom: 6px;">
                        <strong>Jumlah Petani Terdampak:</strong> ${districtData.affected_farmers}
                    </div>
                    <div style="margin-bottom: 6px;">
                        <strong>Luas Lahan Terdampak:</strong> ${districtData.affected_area.toFixed(2)} Ha
                    </div>
                    <div style="margin-top: 8px; padding: 8px; background: #f0fdf4; border-radius: 6px; font-size: 12px;">
                        <strong>Rekomendasi:</strong><br/>
                        ${districtData.recommendation}
                    </div>
                </div>
            `;
            layer.bindPopup(popupContent);
        } else {
            layer.bindPopup(`<strong>${feature.properties.name}</strong><br/>Belum ada data laporan hama`);
        }

        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            click: function(e) {
                layer.openPopup();
            }
        });
    }

    // Create GeoJSON features
    const geojsonFeatures = Object.keys(karawangDistricts).map(districtName => ({
        type: 'Feature',
        properties: { name: districtName },
        geometry: {
            type: 'Polygon',
            coordinates: [[
                ...karawangDistricts[districtName].map(coord => [coord[1], coord[0]])
            ]]
        }
    }));

    // Add GeoJSON layer to map
    const geojson = L.geoJSON(geojsonFeatures, {
        style: style,
        onEachFeature: onEachFeature
    }).addTo(map);

    // Remove default legend since we have custom legend box
</script>
@endpush
