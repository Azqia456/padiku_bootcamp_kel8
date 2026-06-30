@php
    $planting = $farmer->plantings->first() ?? null;
    $statusText = 'Aktif Tanam';
    $statusClass = 'bg-green-100 text-green-700 border-green-200';
    
    if ($farmer->status === 'pending') {
        $statusText = 'Menunggu Persetujuan';
        $statusClass = 'bg-amber-100 text-amber-700 border-amber-200';
    } elseif ($farmer->status === 'rejected') {
        $statusText = 'Ditolak';
        $statusClass = 'bg-red-100 text-red-700 border-red-200';
    } else {
        if ($planting) {
            if ($planting->status === 'persiapan') {
                $statusText = 'Persiapan';
                $statusClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
            } elseif ($planting->status === 'harvested') {
                $statusText = 'Sudah Panen';
                $statusClass = 'bg-blue-100 text-blue-700 border-blue-200';
            }
        }
    }
@endphp

<tr class="farmer-row hover:bg-gray-50" data-name="{{ strtolower($farmer->name) }}" data-district="{{ strtolower($farmer->village ?? '') }}" data-id="{{ $farmer->id }}">
    <td class="px-6 py-4 flex items-center gap-3">
        @if(!empty($farmer->profile_photo_path))
            <img src="{{ asset('storage/' . $farmer->profile_photo_path) }}" alt="Foto {{ $farmer->name }}" class="w-8 h-8 rounded-full object-cover">
        @else
            <div class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold">
                {{ strtoupper(substr($farmer->name, 0, 1)) }}
            </div>
        @endif
        <span class="font-medium text-gray-900">{{ $farmer->name }}</span>
    </td>
    <td class="px-6 py-4 text-gray-600">{{ $farmer->email }}</td>
    <td class="px-6 py-4 text-gray-600">{{ $farmer->phone }}</td>
    <td class="px-6 py-4 text-gray-600">{{ $farmer->village ?? '-' }}</td>
    <td class="px-6 py-4 font-semibold">{{ $farmer->plantings_sum_area_hectares ?? 0 }} Ha</td>
    <td class="px-6 py-4">
        <span class="{{ $statusClass }} px-2.5 py-1 rounded-full text-xs font-semibold border whitespace-nowrap">● {{ $statusText }}</span>
    </td>
    <td class="px-6 py-4 flex justify-center gap-2">
        @if($farmer->status === 'pending')
            <button onclick="openPerizinanModalById({{ $farmer->id }})" class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg border border-emerald-200 hover:bg-emerald-100 transition text-xs font-semibold">Perizinan</button>
        @elseif($farmer->status === 'rejected')
            <button onclick="deleteFarmer(event, {{ $farmer->id }})" class="bg-red-50 text-red-600 px-3 py-1 rounded-lg border border-red-100 hover:bg-red-100 transition text-xs font-semibold">Hapus</button>
        @else
            <button onclick="openEditModal({{ $farmer->id }})" class="bg-orange-50 text-orange-600 px-3 py-1 rounded-lg border border-orange-200 hover:bg-orange-100 transition text-xs font-semibold">Edit</button>
            <button onclick="deleteFarmer(event, {{ $farmer->id }})" class="bg-red-50 text-red-600 px-3 py-1 rounded-lg border border-red-100 hover:bg-red-100 transition text-xs font-semibold">Hapus</button>
        @endif
    </td>
</tr>
