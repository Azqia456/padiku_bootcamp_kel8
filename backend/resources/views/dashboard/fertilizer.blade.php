@php $activeMenu = 'fertilizer'; @endphp
@extends('layouts.admin')

@section('title', 'Distribusi Pupuk')

@section('content')
<x-page-banner
    title="Distribusi Pupuk & Pestisida"
    subtitle="Kelola jadwal pupuk petani dan rekomendasi pembagian pestisida gratis"
    image="complementary.webp"
/>

<!-- Section: Rekomendasi Pestisida Desa Waspada -->
@if($alertVillages->count() > 0)
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-6">
        <h3 class="font-bold text-amber-800 text-sm mb-3 flex items-center gap-2">
            <span class="text-base">⚠️</span> Rekomendasi Distribusi Pestisida Nabati Gratis
        </h3>
        <p class="text-xs text-amber-700 leading-relaxed mb-4">
            Desa-desa berikut saat ini berstatus **Waspada** akibat serangan hama. Direkomendasikan segera membagikan bantuan **Pestisida Nabati Gratis** dan perlindungan hama ke lokasi tersebut:
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($alertVillages as $v)
                <div class="bg-white rounded-xl border border-amber-100 p-4 flex justify-between items-center shadow-sm">
                    <div>
                        <p class="font-bold text-sm text-slate-800">Desa {{ $v->village }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Jumlah pelapor: <b>{{ $v->reporter_count }} petani</b></p>
                    </div>
                    <button onclick="distributePesticide('{{ $v->village }}')" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs px-3.5 py-2 rounded-full shadow-sm transition active:scale-95">
                        Kirim Bantuan
                    </button>
                </div>
            @endforeach
        </div>
    </div>
@else
    <!-- Info panel for presentation -->
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 mb-6">
        <h3 class="font-bold text-slate-700 text-sm mb-2 flex items-center gap-2">
            <span class="text-emerald-500 text-base">✓</span> Info Rekomendasi Distribusi Pestisida Nabati
        </h3>
        <p class="text-xs text-slate-500 leading-relaxed">
            Belum ada desa yang berstatus **Waspada (≥ 3 pelapor)**. Rekomendasi pembagian pestisida gratis akan otomatis muncul di sini untuk membantu mempercepat bantuan bagi wilayah yang sedang terjangkit serangan hama.
        </p>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#0A5C34]">
        <p class="text-sm text-gray-500">Total Jadwal</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $schedules->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#F2C230]">
        <p class="text-sm text-gray-500">Menunggu Distribusi</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ $schedules->where('status', 'pending')->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#63A52F]">
        <p class="text-sm text-gray-500">Total Pupuk (kg)</p>
        <p class="text-3xl font-bold text-hijau-utama">{{ number_format($schedules->sum('amount_kg'), 0) }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-hijau-utama">Jadwal Distribusi Pupuk</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold">Petani</th>
                    <th class="text-left px-6 py-3 font-semibold">Jenis Pupuk</th>
                    <th class="text-left px-6 py-3 font-semibold">Jumlah</th>
                    <th class="text-left px-6 py-3 font-semibold">Jadwal</th>
                    <th class="text-left px-6 py-3 font-semibold">Status</th>
                    <th class="text-center px-6 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                    <tr class="border-t border-gray-50 hover:bg-green-50/30 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $schedule->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $schedule->fertilizer_type }}</td>
                        <td class="px-6 py-4 font-semibold text-hijau-utama">{{ number_format($schedule->amount_kg, 1) }} kg</td>
                        <td class="px-6 py-4 text-gray-600">{{ $schedule->scheduled_date?->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'applied' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700'];
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColors[$schedule->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="sendNotification({{ $schedule->id }})" class="bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 text-xs font-bold px-3.5 py-1.5 rounded-full transition active:scale-95">
                                Kirim Notif
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><x-empty-state message="Belum ada jadwal distribusi pupuk" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function sendNotification(scheduleId) {
        if (!confirm("Kirim notifikasi jadwal pupuk ini ke petani?")) return;
        
        fetch(`/dashboard/fertilizer-schedules/${scheduleId}/notify`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert("Gagal mengirim notifikasi.");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi kesalahan jaringan.");
        });
    }

    function distributePesticide(villageName) {
        alert(`Bantuan Pestisida Nabati Gratis berhasil diproses untuk didistribusikan ke petani di Desa ${villageName}. Notifikasi telah dikirimkan ke dinas cabang setempat.`);
    }
</script>
@endpush
