@php $activeMenu = 'map'; @endphp
@extends('layouts.admin')

@section('title', 'Monitoring Lahan')

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
    .map-hud-title {
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(255,255,255,0.98);
        border: 2px solid #333;
        border-radius: 4px;
        padding: 10px 16px;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
        pointer-events: none;
    }
    .map-hud-title h3 {
        margin: 0;
        font-size: 14px;
        font-weight: 800;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .map-hud-title p {
        margin: 2px 0 0 0;
        font-size: 11px;
        color: #666;
        text-transform: uppercase;
    }
    .map-hud-legend {
        position: absolute;
        bottom: 16px;
        left: 16px;
        background: rgba(255,255,255,0.98);
        border: 2px solid #333;
        border-radius: 4px;
        padding: 12px 14px;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
        width: 160px;
    }
    .map-hud-legend-title {
        font-size: 11px;
        font-weight: 800;
        color: #333;
        text-transform: uppercase;
        border-bottom: 1px solid #ddd;
        padding-bottom: 4px;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }
    .map-hud-legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #444;
    }
    .map-hud-legend-item:last-child {
        margin-bottom: 0;
    }
    .map-hud-color-box {
        width: 14px;
        height: 14px;
        border: 1px solid #333;
        border-radius: 2px;
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
        <div class="bg-white rounded-xl shadow-sm p-4">
            <h2 class="font-bold text-hijau-utama mb-3 text-sm">Peta Fase Pertanian — Kabupaten Karawang</h2>
            <div class="map-wrapper" id="mapWrapper" style="cursor: default;">

                <!-- Floating Legend Card -->
                <div class="map-hud-legend">
                    <div class="map-hud-legend-title">Fase Pertanian</div>
                    <div class="map-hud-legend-item">
                        <div class="map-hud-color-box" style="background: #90EE90;"></div>
                        <span>Baru Tanam</span>
                    </div>
                    <div class="map-hud-legend-item">
                        <div class="map-hud-color-box" style="background: #32CD32;"></div>
                        <span>Pertumbuhan</span>
                    </div>
                    <div class="map-hud-legend-item">
                        <div class="map-hud-color-box" style="background: #FFA500;"></div>
                        <span>Siap Panen</span>
                    </div>
                    <div class="map-hud-legend-item">
                        <div class="map-hud-color-box" style="background: #8B4513;"></div>
                        <span>Selesai Panen</span>
                    </div>
                </div>

                <div id="map" style="width: 100%; height: 100%; z-index: 1;"></div>
            </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        const map = L.map('map').setView([-6.3224, 107.3376], 10);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Data monitoring tanaman per wilayah/kecamatan dari controller
        const plantingData = @json($plantingData);

        const phases = ['planted', 'growing', 'ready', 'harvested'];

        function getKecamatanData(kecamatanName) {
            if (!kecamatanName) return null;
            const norm = kecamatanName.toLowerCase().trim();
            return plantingData.find(item => item.district && item.district.toLowerCase().trim() === norm);
        }

        function getPhaseColor(phase) {
            const colors = {
                'planted': '#90EE90',   // Baru Tanam (Hijau Muda)
                'growing': '#32CD32',   // Pertumbuhan (Hijau Tua)
                'ready': '#FFA500',     // Siap Panen (Kuning/Emas)
                'harvested': '#8B4513'  // Selesai Panen (Cokelat)
            };
            return colors[phase] || '#E5E7EB';
        }

        function getPhaseLabel(phase) {
            const labels = {
                'planted': 'Baru Tanam',
                'growing': 'Pertumbuhan',
                'ready': 'Siap Panen',
                'harvested': 'Selesai Panen'
            };
            return labels[phase] || 'Belum Ada Lahan';
        }

        // Memuat file GeoJSON
        fetch("{{ asset('geojson/karawang-desa.json') }}")
            .then(res => res.json())
            .then(function(geojson) {
                L.geoJSON(geojson, {
                    style: function(feature) {
                        const kecamatan = feature.properties.WADMKC || feature.properties.KECAMATAN || feature.properties.NAME_3 || '';
                        const data = getKecamatanData(kecamatan);
                        let phase = data ? data.dominant_phase : null;
                        
                        // Jika tidak ada data riil, berikan random phase secara stabil berdasarkan hash nama kecamatan
                        if (!phase && kecamatan) {
                            const nameNorm = kecamatan.toLowerCase().trim();
                            let hash = 0;
                            for (let i = 0; i < nameNorm.length; i++) {
                                hash = nameNorm.charCodeAt(i) + ((hash << 5) - hash);
                            }
                            const index = Math.abs(hash) % phases.length;
                            phase = phases[index];
                            feature.properties.randomPhase = phase;
                        }
                        
                        const color = getPhaseColor(phase);
                        
                        return {
                            fillColor: color,
                            weight: 1,
                            opacity: 1,
                            color: 'white',
                            fillOpacity: 0.7
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const namaDesa = feature.properties.NAMOBJ || feature.properties.DESA || feature.properties.NAME_4 || 'Desa';
                        const kecamatan = feature.properties.WADMKC || feature.properties.KECAMATAN || feature.properties.NAME_3 || 'Kecamatan';
                        const data = getKecamatanData(kecamatan);

                        let popupContent = `
                            <div style="font-size: 13px; min-width: 180px;">
                                <b style="color: #0A5C34; font-size: 14px;">${namaDesa}</b><br>
                                <span style="color: #666; font-size: 11px;">Kec. ${kecamatan}</span>
                                <hr style="margin: 6px 0;">
                        `;

                        if (data) {
                            const color = getPhaseColor(data.dominant_phase);
                            const label = getPhaseLabel(data.dominant_phase);
                            const variety = data.common_variety ? data.common_variety.rice_variety : '-';
                            popupContent += `
                                <b>Fase Dominan:</b> <span style="background: ${color}; color: #333; padding: 2px 6px; border-radius: 4px; font-weight: bold; font-size: 11px;">${label}</span><br>
                                <b>Total Lahan:</b> ${data.total_plantings} unit<br>
                                <b>Total Luas:</b> ${parseFloat(data.total_area).toFixed(2)} Ha<br>
                                <b>Estimasi Hasil:</b> ${parseFloat(data.estimated_yield).toFixed(0)} ton<br>
                                <b>Rata-rata Umur:</b> ${data.avg_age_months} bulan<br>
                                <b>Varietas Utama:</b> ${variety}
                            `;
                        } else {
                            // Untuk kebutuhan presentasi, buat data simulasi acak yang tetap stabil
                            const phase = feature.properties.randomPhase || 'planted';
                            const color = getPhaseColor(phase);
                            const label = getPhaseLabel(phase);
                            
                            let hash = 0;
                            const nameNorm = kecamatan.toLowerCase().trim();
                            for (let i = 0; i < nameNorm.length; i++) {
                                hash = nameNorm.charCodeAt(i) + ((hash << 5) - hash);
                            }
                            const seed = Math.abs(hash);
                            const simLahan = (seed % 6) + 2;
                            const simLuas = ((seed % 20) + 5) * 1.8;
                            const simHasil = simLuas * 5.5;
                            const simUmur = (seed % 3) + 1;
                            const varieties = ['Ciherang', 'IR64', 'Mekongga', 'Inpari 32'];
                            const simVariety = varieties[seed % varieties.length];

                            popupContent += `
                                <b>Fase Dominan:</b> <span style="background: ${color}; color: #333; padding: 2px 6px; border-radius: 4px; font-weight: bold; font-size: 11px;">${label}</span><br>
                                <b>Total Lahan (Simulasi):</b> ${simLahan} unit<br>
                                <b>Total Luas (Simulasi):</b> ${simLuas.toFixed(2)} Ha<br>
                                <b>Estimasi Hasil (Simulasi):</b> ${simHasil.toFixed(0)} ton<br>
                                <b>Rata-rata Umur:</b> ${simUmur} bulan<br>
                                <b>Varietas Utama:</b> ${simVariety}
                            `;
                        }

                        popupContent += `</div>`;
                        layer.bindPopup(popupContent);
                    }
                }).addTo(map);
            }).catch(function(error) {
                console.error("Gagal memuat GeoJSON:", error);
                document.getElementById('map').innerHTML = "<div style='padding: 20px; text-align: center; color: red;'>Gagal memuat data peta (pastikan karawang-desa.json ada di public/geojson/)</div>";
            });
    });
</script>
@endpush
