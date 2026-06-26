@php $activeMenu = 'map'; @endphp
@extends('layouts.admin')

@section('title', 'Monitoring Lahan')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #plantingMap {
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
    title="Peta Monitoring Tanam dan Panen"
    subtitle="Kondisi fase pertanian di seluruh wilayah Karawang"
    image="bg.jpg"
/>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <div class="lg:col-span-3">
        <div class="map-container">
            <div class="map-title">
                PETA FASE PERTANIAN
                <div class="map-subtitle">KABUPATEN KARAWANG</div>
            </div>
            <div class="legend-box">
                <div class="legend-title">Fase Pertanian</div>
                <div class="legend-matrix">
                    <div class="legend-row">
                        <div class="legend-label">Baru Tanam</div>
                        <div class="legend-colors">
                            <div class="legend-color" style="background: #90EE90;">A1</div>
                        </div>
                    </div>
                    <div class="legend-row">
                        <div class="legend-label">Pertumbuhan</div>
                        <div class="legend-colors">
                            <div class="legend-color" style="background: #32CD32;">A2</div>
                            <div class="legend-color" style="background: #228B22;">A3</div>
                        </div>
                    </div>
                    <div class="legend-row">
                        <div class="legend-label">Siap Panen</div>
                        <div class="legend-colors">
                            <div class="legend-color" style="background: #FFD700;">B1</div>
                            <div class="legend-color" style="background: #FFA500;">B2</div>
                        </div>
                    </div>
                    <div class="legend-row">
                        <div class="legend-label">Selesai Panen</div>
                        <div class="legend-colors">
                            <div class="legend-color" style="background: #8B4513;">C1</div>
                            <div class="legend-color" style="background: #A0522D;">C2</div>
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
            <div id="plantingMap"></div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Total Lahan</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ $plantings->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500">Total Luas</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ number_format($plantings->sum('area_hectares'), 2) }} Ha</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-emerald-500">
            <p class="text-sm text-gray-500">Estimasi Hasil</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ number_format($plantingData->sum('estimated_yield'), 0) }} ton</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-500">
            <p class="text-sm text-gray-500">Wilayah Aktif</p>
            <p class="text-3xl font-bold text-hijau-utama">{{ $plantingData->count() }}</p>
        </div>
    </div>
</div>

@if($plantingData->count() > 0)
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-hijau-utama">Detail per Wilayah</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold">Wilayah</th>
                    <th class="text-left px-6 py-3 font-semibold">Fase Dominan</th>
                    <th class="text-left px-6 py-3 font-semibold">Komoditas</th>
                    <th class="text-left px-6 py-3 font-semibold">Luas Lahan</th>
                    <th class="text-left px-6 py-3 font-semibold">Umur Tanaman</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plantingData as $data)
                    <tr class="border-t border-gray-50 hover:bg-green-50/30">
                        <td class="px-6 py-3 font-medium">{{ $data->district }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $data->dominant_phase == 'planted' ? 'bg-green-100 text-green-700' : 
                                   ($data->dominant_phase == 'growing' ? 'bg-emerald-100 text-emerald-700' : 
                                   ($data->dominant_phase == 'ready' ? 'bg-yellow-100 text-yellow-700' : 'bg-amber-100 text-amber-700')) }}">
                                {{ $data->phase_label }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">{{ $data->common_variety->rice_variety ?? '-' }}</td>
                        <td class="px-6 py-3 text-hijau-utama font-semibold">{{ number_format($data->total_area, 2) }} Ha</td>
                        <td class="px-6 py-3 text-gray-600">{{ $data->avg_age_months }} bulan</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
    <div class="bg-white rounded-xl shadow-sm"><x-empty-state message="Belum ada data tanam dan panen" /></div>
@endif
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

    // Planting data from server
    const plantingData = @json($plantingData);

    // Initialize map
    const map = L.map('plantingMap').setView([-6.35, 107.35], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Function to get color based on phase with matrix colors
    function getColor(phase) {
        if (phase === 'planted') return '#90EE90'; // Light Green - Baru Tanam (A1)
        if (phase === 'growing') return '#32CD32'; // Lime Green - Masa Pertumbuhan (A2)
        if (phase === 'ready') return '#FFD700'; // Gold - Siap Panen (B1)
        return '#8B4513'; // Saddle Brown - Selesai Panen (C1)
    }

    // Function to style each district with professional cartography style
    function style(feature) {
        const districtData = plantingData.find(d => d.district === feature.properties.name);
        const phase = districtData ? districtData.dominant_phase : 'planted';
        
        return {
            fillColor: getColor(phase),
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
        const districtData = plantingData.find(d => d.district === feature.properties.name);
        
        if (districtData) {
            const popupContent = `
                <div style="min-width: 220px;">
                    <h3 style="font-weight: bold; margin-bottom: 8px; color: #0A5C34;">${districtData.district}</h3>
                    <div style="margin-bottom: 6px;">
                        <strong>Komoditas:</strong> ${districtData.common_variety ? districtData.common_variety.rice_variety : '-'}
                    </div>
                    <div style="margin-bottom: 6px;">
                        <strong>Fase:</strong> 
                        <span style="color: ${getColor(districtData.dominant_phase)}; font-weight: bold;">
                            ${districtData.phase_label}
                        </span>
                    </div>
                    <div style="margin-bottom: 6px;">
                        <strong>Tanggal Tanam:</strong> ${districtData.first_planting ? new Date(districtData.first_planting).toLocaleDateString('id-ID') : '-'}
                    </div>
                    <div style="margin-bottom: 6px;">
                        <strong>Perkiraan Panen:</strong> ${districtData.last_harvest ? new Date(districtData.last_harvest).toLocaleDateString('id-ID') : '-'}
                    </div>
                    <div style="margin-bottom: 6px;">
                        <strong>Umur Tanaman:</strong> ${districtData.avg_age_days} hari (${districtData.avg_age_months} bulan)
                    </div>
                    <div style="margin-bottom: 6px;">
                        <strong>Luas Lahan:</strong> ${districtData.total_area.toFixed(2)} Ha
                    </div>
                    <div style="margin-top: 8px; padding: 8px; background: #fef3c7; border-radius: 6px; font-size: 12px;">
                        <strong>Estimasi Hasil Panen:</strong> ${districtData.estimated_yield.toFixed(0)} ton
                    </div>
                </div>
            `;
            layer.bindPopup(popupContent);
        } else {
            layer.bindPopup(`<strong>${feature.properties.name}</strong><br/>Belum ada data tanam`);
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
