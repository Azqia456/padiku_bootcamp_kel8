@php $activeMenu = 'pest'; @endphp
@extends('layouts.admin')

@section('title', 'Monitoring Hama')

@push('styles')
<style>
    .map-wrapper {
        position: relative;
        width: 100%;
        height: 500px;
        background: #f0f0f0;
        border-radius: 12px;
        overflow: hidden;
        cursor: grab;
        user-select: none;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }
    .map-wrapper:active {
        cursor: grabbing;
    }
    .map-image-inner {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        transform-origin: 0 0;
        will-change: transform;
    }
    .map-image-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        pointer-events: none;
        -webkit-user-drag: none;
    }
    .map-controls {
        position: absolute;
        bottom: 16px;
        right: 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        z-index: 10;
    }
    .map-btn {
        width: 36px;
        height: 36px;
        background: white;
        border: none;
        border-radius: 8px;
        font-size: 20px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s;
        line-height: 1;
    }
    .map-btn:hover { background: #f5f5f5; }
    .map-hint {
        position: absolute;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255,255,255,0.9);
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 11px;
        color: #555;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 6px;
        pointer-events: none;
    }
    .map-hud-title {
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(255,255,255,0.98);
        border: 2px solid #333;
        border-radius: 4px;
        padding: 10px 16px;
        z-index: 10;
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
        z-index: 10;
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
        <div class="bg-white rounded-xl shadow-sm p-4">
            <h2 class="font-bold text-hijau-utama mb-3 text-sm">Peta Sebaran Hama — Kabupaten Karawang</h2>
            <div class="map-wrapper" id="mapWrapper">
                <!-- Floating Title Card -->
                <div class="map-hud-title">
                    <h3>Peta Sebaran Hama</h3>
                    <p>Kabupaten Karawang</p>
                </div>

                <!-- Floating Legend Card -->
                <div class="map-hud-legend">
                    <div class="map-hud-legend-title">Tingkat Serangan</div>
                    <div class="map-hud-legend-item">
                        <div class="map-hud-color-box" style="background: #6BB86B;"></div>
                        <span>Aman</span>
                    </div>
                    <div class="map-hud-legend-item">
                        <div class="map-hud-color-box" style="background: #F5C842;"></div>
                        <span>Waspada</span>
                    </div>
                    <div class="map-hud-legend-item">
                        <div class="map-hud-color-box" style="background: #E8883A;"></div>
                        <span>Tinggi</span>
                    </div>
                    <div class="map-hud-legend-item">
                        <div class="map-hud-color-box" style="background: #D63B2F;"></div>
                        <span>Sangat Tinggi</span>
                    </div>
                </div>

                <div class="map-image-inner" id="mapInner">
                    <img src="{{ asset('images/peta_sebaran_hama.jpg') }}" alt="Peta Sebaran Hama Kabupaten Karawang" draggable="false">
                </div>
                <div class="map-controls">
                    <button class="map-btn" id="zoomIn" title="Zoom In">+</button>
                    <button class="map-btn" id="zoomOut" title="Zoom Out">−</button>
                    <button class="map-btn" id="zoomReset" title="Reset" style="font-size:14px;">⌂</button>
                </div>
                <div class="map-hint">
                    🖱️ Scroll / drag untuk navigasi
                </div>
            </div>
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
<script>
    (function() {
        const wrapper = document.getElementById('mapWrapper');
        const inner   = document.getElementById('mapInner');

        let scale = 1, minScale = 1, maxScale = 5;
        let panX = 0, panY = 0;
        let isPanning = false, startX = 0, startY = 0, startPanX = 0, startPanY = 0;

        function clampPan(x, y, s) {
            const ww = wrapper.clientWidth,  wh = wrapper.clientHeight;
            const iw = ww * s,               ih = wh * s;
            const minX = Math.min(0, ww - iw);
            const minY = Math.min(0, wh - ih);
            return {
                x: Math.min(0, Math.max(x, minX)),
                y: Math.min(0, Math.max(y, minY))
            };
        }

        function applyTransform() {
            inner.style.transform = `translate(${panX}px, ${panY}px) scale(${scale})`;
        }

        // Scroll to zoom
        wrapper.addEventListener('wheel', function(e) {
            e.preventDefault();
            const delta = e.deltaY < 0 ? 1.12 : 0.88;
            const newScale = Math.min(maxScale, Math.max(minScale, scale * delta));

            // Zoom toward cursor position
            const rect = wrapper.getBoundingClientRect();
            const mx = e.clientX - rect.left;
            const my = e.clientY - rect.top;
            panX = mx - (mx - panX) * (newScale / scale);
            panY = my - (my - panY) * (newScale / scale);
            scale = newScale;

            const clamped = clampPan(panX, panY, scale);
            panX = clamped.x; panY = clamped.y;
            applyTransform();
        }, { passive: false });

        // Drag to pan
        wrapper.addEventListener('mousedown', function(e) {
            isPanning = true;
            startX = e.clientX; startY = e.clientY;
            startPanX = panX; startPanY = panY;
            wrapper.style.cursor = 'grabbing';
        });
        window.addEventListener('mousemove', function(e) {
            if (!isPanning) return;
            const dx = e.clientX - startX, dy = e.clientY - startY;
            const clamped = clampPan(startPanX + dx, startPanY + dy, scale);
            panX = clamped.x; panY = clamped.y;
            applyTransform();
        });
        window.addEventListener('mouseup', function() {
            isPanning = false;
            wrapper.style.cursor = 'grab';
        });

        // Touch pan & pinch zoom
        let lastTouchDist = null;
        wrapper.addEventListener('touchstart', function(e) {
            if (e.touches.length === 1) {
                isPanning = true;
                startX = e.touches[0].clientX; startY = e.touches[0].clientY;
                startPanX = panX; startPanY = panY;
            }
        }, { passive: true });
        wrapper.addEventListener('touchmove', function(e) {
            if (e.touches.length === 2) {
                e.preventDefault();
                const dx = e.touches[0].clientX - e.touches[1].clientX;
                const dy = e.touches[0].clientY - e.touches[1].clientY;
                const dist = Math.sqrt(dx*dx + dy*dy);
                if (lastTouchDist !== null) {
                    const delta = dist / lastTouchDist;
                    scale = Math.min(maxScale, Math.max(minScale, scale * delta));
                    const clamped = clampPan(panX, panY, scale);
                    panX = clamped.x; panY = clamped.y;
                    applyTransform();
                }
                lastTouchDist = dist;
            } else if (e.touches.length === 1 && isPanning) {
                const dx = e.touches[0].clientX - startX;
                const dy = e.touches[0].clientY - startY;
                const clamped = clampPan(startPanX + dx, startPanY + dy, scale);
                panX = clamped.x; panY = clamped.y;
                applyTransform();
            }
        }, { passive: false });
        wrapper.addEventListener('touchend', function() {
            isPanning = false;
            lastTouchDist = null;
        });

        // Buttons
        document.getElementById('zoomIn').addEventListener('click', function() {
            scale = Math.min(maxScale, scale * 1.25);
            const clamped = clampPan(panX, panY, scale);
            panX = clamped.x; panY = clamped.y;
            applyTransform();
        });
        document.getElementById('zoomOut').addEventListener('click', function() {
            scale = Math.max(minScale, scale / 1.25);
            const clamped = clampPan(panX, panY, scale);
            panX = clamped.x; panY = clamped.y;
            applyTransform();
        });
        document.getElementById('zoomReset').addEventListener('click', function() {
            scale = 1; panX = 0; panY = 0;
            applyTransform();
        });

        applyTransform();
    })();
</script>
@endpush

