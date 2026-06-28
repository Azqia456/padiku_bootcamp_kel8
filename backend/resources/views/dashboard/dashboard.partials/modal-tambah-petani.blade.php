<div id="modalTambah" class="fixed inset-0 z-50 hidden bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-10 mx-auto p-8 border w-full max-w-2xl shadow-xl rounded-2xl bg-white">
        <h3 class="text-xl font-bold mb-6 text-gray-800">Tambah Petani Baru</h3>
    
        <form action="{{ route('dashboard.farmers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
       
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil Petani</label>
                <input type="file" name="profile_photo" class="w-full border p-2 rounded-lg">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="name" placeholder="Nama Lengkap *" class="border p-3 rounded-lg w-full" required>
                <input type="text" name="nik" placeholder="NIK (16 digit) *" class="border p-3 rounded-lg w-full" required>
                <input type="email" name="email" placeholder="Email *" class="border p-3 rounded-lg w-full" required>
                <input type="text" name="phone" placeholder="Nomor Telepon *" class="border p-3 rounded-lg w-full" required>
                <input type="text" name="district" placeholder="Kecamatan *" class="border p-3 rounded-lg w-full" required>
                <input type="text" name="village" placeholder="Desa *" class="border p-3 rounded-lg w-full" required>
            </div>
            
            <textarea name="address" placeholder="Alamat Lengkap *" class="border p-3 rounded-lg w-full mt-4" rows="2" required></textarea>
            
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="toggleModal('modalTambah', false)" class="px-6 py-2 bg-gray-200 rounded-full hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-6 py-2 bg-[#004d2e] text-white rounded-full hover:bg-green-900">Simpan Petani</button>
            </div>
        </form>
    </div>
</div>