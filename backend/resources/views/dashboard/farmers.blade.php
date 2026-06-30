@php $activeMenu = 'farmers'; @endphp
@extends('layouts.admin')

@section('title', 'Manajemen Petani')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">{{ session('success') }}</div>
@endif

<x-page-banner title="Manajemen Petani" subtitle="Kelola data petani terdaftar di wilayah Karawang" image="Farmers harvesting rice in Vietnam_.jpeg" />

@if($pendingFarmers->count() > 0)
    <!-- Section: Permintaan Persetujuan -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden p-6 border border-slate-100 mb-8 border-l-4 border-yellow-500">
        <div class="mb-4">
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 animate-pulse"></span>
                Permintaan Persetujuan Pendaftaran ({{ $pendingFarmers->count() }})
            </h2>
            <p class="text-sm text-slate-500 font-medium">Akun petani baru yang memerlukan peninjauan berkas</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left">Nama</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-left">Telepon</th>
                        <th class="px-6 py-4 text-left">Kecamatan</th>
                        <th class="px-6 py-4 text-left">Foto Diri</th>
                        <th class="px-6 py-4 text-left">Berkas Pendukung</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($pendingFarmers as $pending)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $pending->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $pending->email }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $pending->phone }}</td>
                        <td class="px-6 py-4 text-slate-500 font-medium">{{ $pending->district }}</td>
                        <td class="px-6 py-4">
                            @if($pending->profile_photo_path)
                                <a href="{{ asset('storage/' . $pending->profile_photo_path) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-semibold underline flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Lihat Foto
                                </a>
                            @else
                                <span class="text-slate-400">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($pending->document_path)
                                <a href="{{ asset('storage/' . $pending->document_path) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-semibold underline flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Lihat Berkas
                                </a>
                            @else
                                <span class="text-slate-400">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <form action="{{ route('dashboard.farmers.approve', $pending->id) }}" method="POST" onsubmit="return confirm('Setujui pendaftaran petani ini?')">
                                    @csrf
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-1.5 rounded-lg transition text-xs font-semibold">Setujui (ACC)</button>
                                </form>
                                <form action="{{ route('dashboard.farmers.reject', $pending->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran petani ini?')">
                                    @csrf
                                    <button type="submit" class="bg-red-50 text-red-600 px-3.5 py-1.5 rounded-lg border border-red-100 hover:bg-red-100/50 transition text-xs font-semibold">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden p-6 border border-slate-100">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 mt-2">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Petani</h2>
            <p class="text-sm text-slate-500 font-medium" id="farmerCount">{{ $farmers->count() }} petani terdaftar</p>
        </div>
       
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <input type="text" id="searchInput" placeholder="Cari petani..." 
                   class="border border-slate-200 rounded-full px-5 py-2.5 w-full sm:w-64 focus:ring-2 focus:ring-green-600 outline-none transition text-sm">
        </div>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] tracking-wider font-semibold border-b border-slate-100">
            <tr>
                <th class="px-6 py-4 text-left">Nama</th>
                <th class="px-6 py-4 text-left">Email</th>
                <th class="px-6 py-4 text-left">Telepon</th>
                <th class="px-6 py-4 text-left">Kecamatan</th>
                <th class="px-6 py-4 text-left">Lahan</th>
                <th class="px-6 py-4 text-left">Status</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="farmersTableBody" class="divide-y divide-slate-100">
            @foreach($farmers as $farmer)
                @include('dashboard.farmers.partials.farmer-row', ['farmer' => $farmer])
            @endforeach
        </tbody>
    </table>
</div>

<div id="modalEdit" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-1">
            <h2 class="text-xl font-bold flex items-center gap-2">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Data Petani
            </h2>
            <button type="button" onclick="toggleModal('modalEdit', false)" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <p class="text-gray-500 text-sm mb-6 ml-8">Perbarui data petani yang terdaftar di sistem PADIKU.</p>

        <form id="editFarmerForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_farmer_id" name="farmer_id">
            <div class="mb-6">
                <h3 class="text-xs font-bold text-hijau-utama mb-3 tracking-wider">DATA DIRI</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_name" name="name" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">NIK (16 digit) <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_nik" name="nik" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="edit_email" name="email" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_phone" name="phone" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-xs font-bold text-hijau-utama mb-3 tracking-wider">LOKASI</h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_district" name="district" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Desa / Kelurahan <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_village" name="village" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_address" name="address" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-xs font-bold text-hijau-utama mb-3 tracking-wider">DATA LAHAN & TANAM</h3>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Luas Lahan (Ha) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" id="edit_area_hectares" name="area_hectares" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Varietas Padi <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_rice_variety" name="rice_variety" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select id="edit_status" name="status" class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none bg-white">
                            <option value="persiapan">Persiapan</option>
                            <option value="planted">Aktif Tanam</option>
                            <option value="harvested">Sudah Panen</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                    <textarea id="edit_notes" name="notes" class="border border-gray-300 p-2 rounded-lg w-full h-20 focus:ring-1 focus:ring-hijau-utama outline-none"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-4 pt-4 border-t">
                <button type="button" onclick="toggleModal('modalEdit', false)" class="px-6 py-2 bg-white border border-gray-300 rounded-full text-gray-700 font-medium hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-full font-medium hover:bg-orange-700 transition-colors">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    let allFarmers = @json($farmers);

    function toggleModal(modalId, show) {
        const modal = document.getElementById(modalId);
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    function getStatusClass(status) {
        if (status === 'persiapan') return 'bg-yellow-100 text-yellow-700';
        if (status === 'harvested') return 'bg-blue-100 text-blue-700';
        return 'bg-green-100 text-green-700';
    }

    function getStatusText(status) {
        if (status === 'persiapan') return 'Persiapan';
        if (status === 'harvested') return 'Sudah Panen';
        return 'Aktif Tanam';
    }

    function renderFarmerRow(farmer) {
        const planting = farmer.plantings && farmer.plantings.length > 0 ? farmer.plantings[0] : null;
        const area = farmer.plantings_sum_area_hectares || 0;
        const status = planting ? planting.status : 'planted';

        let photoHtml = '';
        if (farmer.profile_photo_path) {
            photoHtml = `<img src="{{ asset('storage/') }}/${farmer.profile_photo_path}" alt="Foto ${farmer.name}" class="w-8 h-8 rounded-full object-cover">`;
        } else {
            photoHtml = `<div class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold">${farmer.name.charAt(0).toUpperCase()}</div>`;
        }

        return `
            <tr class="farmer-row hover:bg-slate-50/50 transition-colors" data-name="${farmer.name.toLowerCase()}" data-district="${farmer.district.toLowerCase()}" data-id="${farmer.id}">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        ${photoHtml}
                        <span class="font-semibold text-slate-800">${farmer.name}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600">${farmer.email}</td>
                <td class="px-6 py-4 text-slate-600">${farmer.phone}</td>
                <td class="px-6 py-4 text-slate-500 font-medium">${farmer.district}</td>
                <td class="px-6 py-4 font-bold text-emerald-800">${area} Ha</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold ${getStatusClass(status)} border border-emerald-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        ${getStatusText(status)}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-center items-center gap-2">
                        <button onclick="openEditModal(${farmer.id})" class="bg-orange-50 text-orange-600 px-3.5 py-1.5 rounded-lg border border-orange-200 hover:bg-orange-100 transition text-xs font-semibold">Edit</button>
                        <button onclick="deleteFarmer(event, ${farmer.id})" class="bg-red-50 text-red-600 px-3.5 py-1.5 rounded-lg border border-red-100 hover:bg-red-100/50 transition text-xs font-semibold">Hapus</button>
                    </div>
                </td>
            </tr>
        `;
    }

    function updateFarmerCount() {
        const visibleRows = document.querySelectorAll('.farmer-row:not([style*="display: none"])');
        document.getElementById('farmerCount').textContent = `${visibleRows.length} petani terdaftar`;
    }

    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.farmer-row').forEach(row => {
            const name = row.dataset.name;
            const district = row.dataset.district;
            if (name.includes(searchTerm) || district.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateFarmerCount();
    });

    async function openEditModal(farmerId) {
        try {
            const response = await fetch(`/dashboard/farmers/${farmerId}/edit`);
            const farmer = await response.json();

            document.getElementById('edit_farmer_id').value = farmer.id;
            document.getElementById('edit_name').value = farmer.name;
            document.getElementById('edit_nik').value = farmer.nik;
            document.getElementById('edit_email').value = farmer.email;
            document.getElementById('edit_phone').value = farmer.phone;
            document.getElementById('edit_district').value = farmer.district;
            document.getElementById('edit_village').value = farmer.village;
            document.getElementById('edit_address').value = farmer.address;

            if (farmer.plantings && farmer.plantings.length > 0) {
                const planting = farmer.plantings[0];
                document.getElementById('edit_area_hectares').value = planting.area_hectares;
                document.getElementById('edit_rice_variety').value = planting.rice_variety;
                document.getElementById('edit_status').value = planting.status;
                document.getElementById('edit_notes').value = planting.notes || '';
            }

            toggleModal('modalEdit', true);
        } catch (error) {
            console.error('Error fetching farmer data:', error);
            alert('Gagal memuat data petani');
        }
    }

    document.getElementById('editFarmerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const farmerId = document.getElementById('edit_farmer_id').value;
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Menyimpan...';

        try {
            const response = await fetch(`/dashboard/farmers/${farmerId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await response.json();
            
            if (data.success) {
                const index = allFarmers.findIndex(f => f.id === data.farmer.id);
                if (index !== -1) {
                    allFarmers[index] = data.farmer;
                }
                const oldRow = document.querySelector(`.farmer-row[data-id="${farmerId}"]`);
                if (oldRow) {
                    oldRow.outerHTML = renderFarmerRow(data.farmer);
                }
                toggleModal('modalEdit', false);
                alert('Data petani berhasil diperbarui!');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal memperbarui data petani');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Simpan Perubahan';
        }
    });

    async function deleteFarmer(event, farmerId) {
        event.preventDefault();
        if (!confirm('Yakin ingin menghapus data petani ini?')) {
            return;
        }
        
        try {
            const response = await fetch(`/dashboard/farmers/${farmerId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            
            if (data.success) {
                allFarmers = allFarmers.filter(f => f.id !== farmerId);
                const row = document.querySelector(`.farmer-row[data-id="${farmerId}"]`);
                if (row) {
                    row.remove();
                }
                updateFarmerCount();
                alert('Petani berhasil dihapus!');
            } else {
                alert('Gagal menghapus petani');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal menghapus petani');
        }
    }
</script>

@endsection
