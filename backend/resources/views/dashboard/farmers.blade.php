@php $activeMenu = 'farmers'; @endphp

@extends('layouts.admin')

@section('title', 'Manajemen Petani')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">{{ session('success') }}</div>
@endif

<x-page-banner title="Manajemen Petani" subtitle="Kelola data petani terdaftar di wilayah Karawang" image="Farmers harvesting rice in Vietnam_.jpeg" />

<div class="bg-white rounded-xl shadow-sm overflow-hidden p-6">
    <div class="flex justify-between items-center mb-6 mt-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Petani</h2>
            <p class="text-sm text-gray-500 font-medium" id="farmerCount">{{ $farmers->count() }} petani terdaftar</p>
        </div>

        <div class="flex items-center gap-3">
            <input type="text" id="searchInput" placeholder="Cari petani..."
                   class="border border-gray-300 rounded-full px-5 py-2.5 w-64 focus:ring-2 focus:ring-green-600 outline-none transition">

            <button onclick="toggleModal('modalTambah', true)"
                    class="bg-[#004d2e] text-white px-6 py-2.5 rounded-full font-semibold hover:bg-green-900 transition flex items-center gap-2">
                <span>+</span> Tambah Petani
            </button>
        </div>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
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
        <tbody id="farmersTableBody" class="divide-y">
            @foreach($farmers as $farmer)
                @include('dashboard.farmers.partials.farmer-row', ['farmer' => $farmer])
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Petani -->
<div id="modalTambah" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-1">
            <h2 class="text-xl font-bold flex items-center gap-2">
                <svg class="w-6 h-6 text-hijau-utama" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Petani Baru
            </h2>
            <button type="button" onclick="toggleModal('modalTambah', false)" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <p class="text-gray-500 text-sm mb-6 ml-8">Lengkapi data petani untuk didaftarkan ke sistem PADIKU.</p>

        <form id="storeFarmerForm" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <h3 class="text-xs font-bold text-hijau-utama mb-3 tracking-wider">DATA DIRI</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" placeholder="Bapak / Ibu ..." required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">NIK (16 digit) <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" placeholder="3215xxxxxxxxxxxx" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" placeholder="nama@karawang.id" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" placeholder="0812-3456-7890" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-xs font-bold text-hijau-utama mb-3 tracking-wider">LOKASI</h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                        <input type="text" name="district" placeholder="Ketik kecamatan" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Desa / Kelurahan <span class="text-red-500">*</span></label>
                        <input type="text" name="village" placeholder="Nama desa" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="address" placeholder="Dusun, RT/RW, jalan..." required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-xs font-bold text-hijau-utama mb-3 tracking-wider">DATA LAHAN & TANAM</h3>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Luas Lahan (Ha) <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="area_hectares" placeholder="2.5" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Varietas Padi <span class="text-red-500">*</span></label>
                        <input type="text" name="rice_variety" placeholder="Ciherang" required class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" class="border border-gray-300 p-2 rounded-lg w-full focus:ring-1 focus:ring-hijau-utama outline-none bg-white">
                            <option value="persiapan">Persiapan</option>
                            <option value="planted">Aktif Tanam</option>
                            <option value="harvested">Sudah Panen</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                    <textarea name="notes" placeholder="Informasi tambahan tentang petani..." class="border border-gray-300 p-2 rounded-lg w-full h-20 focus:ring-1 focus:ring-hijau-utama outline-none"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-4 pt-4 border-t">
                <button type="button" onclick="toggleModal('modalTambah', false)" class="px-6 py-2 bg-white border border-gray-300 rounded-full text-gray-700 font-medium hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2 bg-hijau-utama text-white rounded-full font-medium hover:bg-green-800 transition-colors">Simpan Petani</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Petani -->
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
                <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-full font-medium hover:bg-orange-700 transition-colors">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Global variables
    let allFarmers = @json($farmers);

    function toggleModal(modalId, show) {
        const modal = document.getElementById(modalId);
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    // Helper function to get status class
    function getStatusClass(status) {
        if (status === 'persiapan') return 'bg-yellow-100 text-yellow-700';
        if (status === 'harvested') return 'bg-blue-100 text-blue-700';
        return 'bg-green-100 text-green-700';
    }

    // Helper function to get status text
    function getStatusText(status) {
        if (status === 'persiapan') return 'Persiapan';
        if (status === 'harvested') return 'Sudah Panen';
        return 'Aktif Tanam';
    }

    // Render farmer row
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
            <tr class="farmer-row hover:bg-gray-50" data-name="${farmer.name.toLowerCase()}" data-district="${farmer.district.toLowerCase()}" data-id="${farmer.id}">
                <td class="px-6 py-4 flex items-center gap-3">
                    ${photoHtml}
                    <span class="font-medium text-gray-900">${farmer.name}</span>
                </td>
                <td class="px-6 py-4 text-gray-600">${farmer.email}</td>
                <td class="px-6 py-4 text-gray-600">${farmer.phone}</td>
                <td class="px-6 py-4 text-gray-600">${farmer.district}</td>
                <td class="px-6 py-4 font-semibold">${area} Ha</td>
                <td class="px-6 py-4">
                    <span class="${getStatusClass(status)} px-2 py-1 rounded-full text-xs">● ${getStatusText(status)}</span>
                </td>
                <td class="px-6 py-4 flex justify-center gap-2">
                    <button onclick="openEditModal(${farmer.id})" class="bg-orange-50 text-orange-600 px-3 py-1 rounded-lg border border-orange-200 hover:bg-orange-100 transition">Edit</button>
                    <button onclick="deleteFarmer(${farmer.id})" class="bg-red-50 text-red-600 px-3 py-1 rounded-lg border border-red-200 hover:bg-red-100 transition">Hapus</button>
                </td>
            </tr>
        `;
    }

    // Update farmer count
    function updateFarmerCount() {
        const visibleRows = document.querySelectorAll('.farmer-row:not([style*="display: none"])');
        document.getElementById('farmerCount').textContent = `${visibleRows.length} petani terdaftar`;
    }

    // Real-time search
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

    // Store Farmer
    document.getElementById('storeFarmerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch('{{ route('dashboard.farmers.store') }}', {
                method: 'POST',
                headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
        });

        const data = await response.json();
        
        if (data.success) {
            // Add new farmer to allFarmers array
            allFarmers.push(data.farmer);
            // Add new row to table
            const tbody = document.getElementById('farmersTableBody');
            tbody.insertAdjacentHTML('beforeend', renderFarmerRow(data.farmer));
            // Reset form and close modal
            this.reset();
            toggleModal('modalTambah', false);
            // Show success message
            alert(data.message);
            // Update count
            updateFarmerCount();
        }
        // Re-apply search filter
        searchInput.dispatchEvent(new Event('input'));
        } catch (error) {
        console.error('Error:', error);
        alert('Gagal menyimpan data petani');
        }
    });

    // Open Edit Modal
    async function openEditModal(farmerId) {
        try {
            const response = await fetch(`/dashboard/farmers/${farmerId}/edit`);
            const farmer = await response.json();

            // Populate form
            document.getElementById('edit_farmer_id').value = farmer.id;
            document.getElementById('edit_name').value = farmer.name;
            document.getElementById('edit_nik').value = farmer.nik;
            document.getElementById('edit_email').value = farmer.email;
            document.getElementById('edit_phone').value = farmer.phone;
            document.getElementById('edit_district').value = farmer.district;
            document.getElementById('edit_village').value = farmer.village;
            document.getElementById('edit_address').value = farmer.address;

            // Populate planting data
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

    // Update Farmer
    document.getElementById('editFarmerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const farmerId = document.getElementById('edit_farmer_id').value;
        const formData = new FormData(this);

        try {
            const response = await fetch(`/dashboard/farmers/${farmerId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await response.json();
            
            if (data.success) {
                // Update in allFarmers array
                const index = allFarmers.findIndex(f => f.id === data.farmer.id);
                if (index !== -1) {
                    allFarmers[index] = data.farmer;
                }
                // Update row in table
                const oldRow = document.querySelector(`.farmer-row[data-id="${farmerId}"]`);
                if (oldRow) {
                    oldRow.outerHTML = renderFarmerRow(data.farmer);
                }
                // Reset form and close modal
                this.reset();
                toggleModal('modalEdit', false);
                // Show success message
                alert(data.message);
                // Re-apply search filter
                searchInput.dispatchEvent(new Event('input'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal memperbarui data petani');
        }
    });

    // Delete Farmer
    async function deleteFarmer(farmerId) {
        if (!confirm('Yakin ingin menghapus data petani ini?')) {
            return;
        }
        
        try {
            const response = await fetch(`/dashboard/farmers/${farmerId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            const data = await response.json();
            if (data.success) {
                // Remove from allFarmers
                allFarmers = allFarmers.filter(f => f.id !== farmerId);
                // Remove from table
                const row = document.querySelector(`.farmer-row[data-id="${farmerId}"]`);
                if (row) {
                    row.remove();
                }
                updateFarmerCount();
                alert(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Gagal menghapus data petani');
        }
    }
</script>

@endsection
