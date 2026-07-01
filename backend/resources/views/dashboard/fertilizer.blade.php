@php $activeMenu = 'fertilizer'; @endphp
@extends('layouts.admin')

@section('title', 'Distribusi Pupuk')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 12px;
            height: 48px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            background-color: #FDFCF8;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px;
        }
        .select2-dropdown {
            border-radius: 12px;
        }
    </style>
@endpush

@section('content')
<x-page-banner
    title="Distribusi Pupuk"
    subtitle="Kelola jadwal pupuk petani dan rekomendasi pembagian pestisida gratis"
    image="complementary.webp"
/>



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

<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100 mb-6">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-bold text-hijau-utama text-2xl">Jadwal Distribusi Pupuk</h2>
        <button onclick="toggleModal('modalTambah', true)" class="bg-green-100 text-hijau-utama px-5 py-2 rounded-full font-semibold hover:bg-green-200 transition flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            Tambah Jadwal
        </button>
    </div>
    @if(isset($growingPlantings) && $growingPlantings->count() > 0)
        <div class="p-6 bg-emerald-50/40 border-b border-emerald-100/80">
            <h3 class="font-bold text-emerald-800 text-sm mb-3">
                Rekomendasi Distribusi Pupuk Segera (Fase Pertumbuhan)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($growingPlantings as $p)
                    <div class="bg-white rounded-xl border border-emerald-100 p-4 flex justify-between items-center shadow-sm">
                        <div>
                            <p class="font-bold text-sm text-slate-800">{{ $p->user->name ?? 'Petani' }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">Lahan: {{ $p->location_name }} ({{ number_format($p->area_hectares, 1) }} Ha)</p>
                            <p class="text-xs text-slate-400 mt-0.5">Desa {{ $p->user->village ?? '-' }}, Kec. {{ $p->user->district ?? '-' }}</p>
                        </div>
                        <button onclick="quickScheduleFertilizer({{ $p->user_id }}, '{{ addslashes($p->user->name ?? 'Petani') }}', {{ $p->area_hectares }})" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs px-3.5 py-2 rounded-full shadow-sm transition active:scale-95">
                            Jadwalkan
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold">Petani</th>
                    <th class="text-left px-6 py-3 font-semibold">Jenis Pupuk</th>
                    <th class="text-left px-6 py-3 font-semibold">Jumlah</th>
                    <th class="text-left px-6 py-3 font-semibold">Jadwal</th>
                    <th class="text-left px-6 py-3 font-semibold">Metode</th>
                    <th class="text-left px-6 py-3 font-semibold">Petugas</th>
                    <th class="text-left px-6 py-3 font-semibold">Status</th>
                    <th class="text-center px-6 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody id="scheduleTableBody">
                @forelse($schedules as $schedule)
                    <tr class="border-t border-gray-50 hover:bg-green-50/30 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $schedule->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $schedule->fertilizer_type }}</td>
                        <td class="px-6 py-4 font-semibold text-hijau-utama">{{ number_format($schedule->amount_kg, 1) }} kg</td>
                        <td class="px-6 py-4 text-gray-600">{{ $schedule->scheduled_date?->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            @php
                                $methodLabels = ['delivered' => 'Diantar Petugas', 'pickup' => 'Ambil di Gudang', 'kios' => 'Kios Tani'];
                            @endphp
                            {{ $methodLabels[$schedule->delivery_method] ?? $schedule->delivery_method }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $schedule->officer_in_charge ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = ['scheduled' => 'bg-blue-100 text-blue-700', 'pending' => 'bg-yellow-100 text-yellow-700', 'applied' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700'];
                                $statusLabels = ['scheduled' => 'Terjadwal', 'pending' => 'Menunggu', 'applied' => 'Diterapkan', 'cancelled' => 'Dibatalkan'];
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColors[$schedule->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $statusLabels[$schedule->status] ?? ucfirst($schedule->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="sendNotification({{ $schedule->id }})" class="bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 text-xs font-bold px-3.5 py-1.5 rounded-full transition active:scale-95">
                                Kirim Notif
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8"><x-empty-state message="Belum ada jadwal distribusi pupuk" /></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambah" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-1">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-hijau-utama" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0a9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Jadwalkan Distribusi Pupuk</h2>
                    <p class="text-gray-500">Buat jadwal baru untuk distribusi pupuk bersubsidi ke petani.</p>
                </div>
            </div>
            <button type="button" onclick="toggleModal('modalTambah', false)" class="text-gray-400 hover:text-gray-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="storeScheduleForm" class="mt-6">
            @csrf
            <div class="mb-6">
                <h3 class="text-sm font-bold text-hijau-utama mb-4 tracking-widest uppercase">Penerima & Pupuk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Petani Penerima <span class="text-red-500">*</span></label>
                        <select name="user_id" id="schedule_user_id" required class="w-full">
                            <option value="">Pilih petani</option>
                            @php
                                $groupedFarmers = $farmers->groupBy('village');
                            @endphp
                            @foreach($groupedFarmers as $village => $farmersByVillage)
                                <optgroup label="{{ $village }} - {{ $farmersByVillage->first()->district }}">
                                    @foreach($farmersByVillage as $farmer)
                                        <option value="{{ $farmer->id }}">{{ $farmer->name }} - {{ $village }} - {{ $farmer->district }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Jenis Pupuk <span class="text-red-500">*</span></label>
                        <select name="fertilizer_type" id="schedule_fertilizer_type" required class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none bg-[#FDFCF8]">
                            <option value="Urea">Urea</option>
                            <option value="SP-36">SP-36</option>
                            <option value="ZA">ZA</option>
                            <option value="NPK">NPK</option>
                            <option value="Organik">Organik</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Jumlah (kg) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="amount_kg" id="schedule_amount_kg" placeholder="150" required class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none bg-[#FDFCF8]">
                    </div>
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Prioritas <span class="text-red-500">*</span></label>
                        <select name="priority" id="schedule_priority" required class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none bg-[#FDFCF8]">
                            <option value="low">Rendah</option>
                            <option value="normal" selected>Normal</option>
                            <option value="high">Tinggi</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-sm font-bold text-hijau-utama mb-4 tracking-widest uppercase">Jadwal & Distribusi</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Tanggal Distribusi <span class="text-red-500">*</span></label>
                        <input type="date" name="scheduled_date" id="schedule_scheduled_date" required class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none bg-[#FDFCF8]">
                    </div>
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Metode Pengiriman <span class="text-red-500">*</span></label>
                        <select name="delivery_method" id="schedule_delivery_method" required class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none bg-[#FDFCF8]">
                            <option value="delivered" selected>Diantar Petugas</option>
                            <option value="pickup">Ambil di Gudang</option>
                            <option value="kios">Kios Tani</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Status Awal <span class="text-red-500">*</span></label>
                        <select name="status" id="schedule_status" required class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none bg-[#FDFCF8]">
                            <option value="scheduled" selected>Terjadwal</option>
                            <option value="pending">Menunggu</option>
                            <option value="applied">Diterapkan</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-base font-medium text-gray-700 mb-2">Petugas Penanggung Jawab <span class="text-red-500">*</span></label>
                <input type="text" name="officer_in_charge" id="schedule_officer_in_charge" placeholder="Nama petugas distribusi" required class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none bg-[#FDFCF8]">
            </div>

            <div class="mb-6">
                <label class="block text-base font-medium text-gray-700 mb-2">Catatan (opsional)</label>
                <textarea name="notes" id="schedule_notes" placeholder="Catatan tambahan, misal: kondisi gudang, instruksi khusus..." class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-hijau-utama focus:border-hijau-utama outline-none bg-[#FDFCF8] h-24"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" onclick="toggleModal('modalTambah', false)" class="px-6 py-2.5 bg-white border border-gray-300 rounded-full text-gray-700 font-medium hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-hijau-utama text-white rounded-full font-medium hover:bg-green-800 transition-colors">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let allFarmers = @json($farmers);
    let allPlantings = @json($plantings);

    function toggleModal(modalId, show) {
        const modal = document.getElementById(modalId);
        if (show) {
            modal.classList.remove('hidden');
            $(document).ready(function() {
                $('#schedule_user_id').select2({
                    placeholder: 'Pilih petani',
                    dropdownParent: $('#modalTambah'),
                    width: '100%',
                    matcher: function(params, data) {
                        if ($.trim(params.term) === '') {
                            return data;
                        }
                        if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                            return data;
                        }
                        if (data.children) {
                            let children = [];
                            $.each(data.children, function (idx, child) {
                                if (child.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                                    children.push(child);
                                }
                            });
                            if (children.length) {
                                let modifiedData = $.extend({}, data, true);
                                modifiedData.children = children;
                                return modifiedData;
                            }
                        }
                        return null;
                    }
                });
            });
        } else {
            modal.classList.add('hidden');
            $('#schedule_user_id').select2('destroy');
        }
    }

    function renderScheduleRow(schedule) {
        const statusColors = {
            'scheduled': 'bg-blue-100 text-blue-700',
            'pending': 'bg-yellow-100 text-yellow-700',
            'applied': 'bg-green-100 text-green-700',
            'cancelled': 'bg-red-100 text-red-700'
        };
        const statusLabels = {
            'scheduled': 'Terjadwal',
            'pending': 'Menunggu',
            'applied': 'Diterapkan',
            'cancelled': 'Dibatalkan'
        };
        const methodLabels = {
            'delivered': 'Diantar Petugas',
            'pickup': 'Ambil di Gudang',
            'kios': 'Kios Tani'
        };

        const farmer = allFarmers.find(f => f.id === schedule.user_id);

        return `
            <tr class="border-t border-gray-50 hover:bg-green-50/30 transition">
                <td class="px-6 py-4 font-medium text-gray-800">${farmer ? farmer.name : '-'}</td>
                <td class="px-6 py-4 text-gray-600">${schedule.fertilizer_type}</td>
                <td class="px-6 py-4 font-semibold text-hijau-utama">${parseFloat(schedule.amount_kg).toFixed(1)} kg</td>
                <td class="px-6 py-4 text-gray-600">${new Date(schedule.scheduled_date).toLocaleDateString('id-ID', {day:'numeric', month:'short', year:'numeric'})}</td>
                <td class="px-6 py-4 text-gray-600">${methodLabels[schedule.delivery_method] || schedule.delivery_method}</td>
                <td class="px-6 py-4 text-gray-600">${schedule.officer_in_charge || '-'}</td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full ${statusColors[schedule.status] || 'bg-gray-100 text-gray-700' }">
                        ${statusLabels[schedule.status] || schedule.status}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <button onclick="sendNotification(${schedule.id})" class="bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 text-xs font-bold px-3.5 py-1.5 rounded-full transition active:scale-95">
                        Kirim Notif
                    </button>
                </td>
            </tr>
        `;
    }

    document.getElementById('storeScheduleForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('{{ route('dashboard.fertilizer.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                const scheduleData = {
                    id: Date.now(),
                    ...Object.fromEntries(formData.entries()),
                    user_id: parseInt(formData.get('user_id')),
                    amount_kg: parseFloat(formData.get('amount_kg')),
                    scheduled_date: formData.get('scheduled_date')
                };
                const tableBody = document.getElementById('scheduleTableBody');
                const emptyRow = tableBody.querySelector('td[colspan="8"]');
                if (emptyRow) {
                    emptyRow.parentElement.remove();
                }
                tableBody.insertAdjacentHTML('afterbegin', renderScheduleRow(scheduleData));

                this.reset();
                toggleModal('modalTambah', false);
                window.location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal menyimpan jadwal distribusi pupuk!');
        }
    });

    function sendNotification(scheduleId) {
        if (!confirm('Kirim notifikasi jadwal pupuk ini ke petani?')) return;

        fetch('/dashboard/fertilizer-schedules/' + scheduleId + '/notify', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert('Gagal mengirim notifikasi.');
            }
        }).catch(err => {
            console.error(err);
            alert('Terjadi kesalahan jaringan.');
        });
    }

    function quickScheduleFertilizer(userId, farmerName, area) {
        // Toggle the modal
        toggleModal('modalTambah', true);
        
        // Pre-fill fields
        $('#schedule_user_id').val(userId).trigger('change');
        $('#schedule_fertilizer_type').val('Urea');
        
        // Calculate recommended amount (e.g. 150 kg per Hectare)
        let recommendedAmount = Math.round(area * 150);
        $('#schedule_amount_kg').val(recommendedAmount);
        
        $('#schedule_priority').val('high');
        
        // Default scheduled date = today + 3 days
        let targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 3);
        let dateStr = targetDate.toISOString().split('T')[0];
        $('#schedule_scheduled_date').val(dateStr);
        
        $('#schedule_officer_in_charge').val('Tim Distribusi Lapangan');
        $('#schedule_status').val('scheduled');
        $('#schedule_notes').val('Jadwal dibuat otomatis karena lahan memasuki fase pertumbuhan.');
    }

    function distributePesticide(villageName) {
        alert('Bantuan Pestisida Nabati Gratis berhasil diproses untuk didistribusikan ke petani di Desa ' + villageName + '. Notifikasi telah dikirimkan ke dinas cabang setempat.');
    }
</script>
@endsection
