@php $activeMenu = 'farmers'; @endphp

@extends('layouts.admin')



@section('title', 'Manajemen Petani')



@section('content')



@if(session('success'))

    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">{{ session('success') }}</div>

@endif



<x-page-banner title="Manajemen Petani" subtitle="Kelola data petani terdaftar di wilayah Karawang" image="bg_petani.png" />

<div class="bg-white rounded-xl shadow-sm overflow-hidden p-6 border border-slate-100">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 mt-2">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Petani</h2>
            <p class="text-sm text-slate-500 font-medium">{{ $farmers->count() }} petani terdaftar</p>
        </div>
       
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <form action="{{ route('dashboard.farmers') }}" method="GET" class="flex flex-1 sm:flex-initial">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari petani..."
                       class="border border-slate-200 rounded-full px-5 py-2.5 w-full sm:w-64 focus:ring-2 focus:ring-green-600 outline-none transition text-sm">
            </form>
           
            <button onclick="toggleModal('modalTambah', true)"
                    class="bg-[#004d2e] text-white px-6 py-2.5 rounded-full font-semibold hover:bg-green-900 transition flex items-center gap-2 text-sm shrink-0">
                <span>+</span> Tambah Petani
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
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
            <tbody class="divide-y divide-slate-100">
                @foreach($farmers as $farmer)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if(!empty($farmer->profile_photo_path))
                                <img src="{{ asset('storage/' . $farmer->profile_photo_path) }}" alt="Foto {{ $farmer->name }}"
                                     class="w-9 h-9 rounded-full object-cover border border-slate-200">
                            @else
                                <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-sm border border-emerald-100">
                                    {{ strtoupper(substr($farmer->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="font-semibold text-slate-800">{{ $farmer->name }}</span>
                        </div>
                    </td>
                   
                    <td class="px-6 py-4 text-slate-600">{{ $farmer->email }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $farmer->phone }}</td>
                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $farmer->district }}</td>
                    <td class="px-6 py-4 font-bold text-emerald-800">{{ $farmer->plantings_sum_area_hectares ?? 0 }} Ha</td>
                   
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Aktif Tanam
                        </span>
                    </td>
                   
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-2">
                            <button class="bg-slate-50 text-slate-600 px-3.5 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-100 transition text-xs font-semibold">Edit</button>
                            <form action="{{ route('dashboard.farmers.destroy', $farmer->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-50 text-red-600 px-3.5 py-1.5 rounded-lg border border-red-100 hover:bg-red-100/50 transition text-xs font-semibold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
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

       

        <form action="{{ route('dashboard.farmers.store') }}" method="POST">

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



<script>

    function toggleModal(modalId, show) {

        const modal = document.getElementById(modalId);

        if (show) {

            modal.classList.remove('hidden');

        } else {

            modal.classList.add('hidden');

        }

    }

</script>

@endsection 

