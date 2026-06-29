<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Planting;
use App\Models\PestReport;

class CikampekPusakaSeeder extends Seeder
{
    /**
     * Buat 3 akun petani dari Desa Cikampek Pusaka untuk testing algoritma threshold.
     *
     * Threshold status peta:
     *   < 3  pelapor unik → Aman       (hijau)
     *   3–9  pelapor unik → Waspada    (kuning)
     *   10–19 pelapor     → Tinggi     (oranye)
     *   ≥ 20 pelapor      → Sangat Tinggi (merah)
     *
     * Dengan 3 laporan ini, Cikampek Pusaka akan tampil WASPADA (kuning) di peta.
     */
    public function run(): void
    {
        $desaName  = 'Cikampek Pusaka';
        $kecamatan = 'Cikampek';
        $lat       = -6.4234;
        $lon       = 107.4512;

        $petani = [
            [
                'name'    => 'Budi Santoso',
                'email'   => 'budi.cikampek@padiku.test',
                'nik'     => '3215010101800001',
                'phone'   => '081311110001',
                'lat'     => $lat,
                'lon'     => $lon,
                'area'    => 1.50,
                'variety' => 'Ciherang',
                'pest'    => 'Wereng Batang Coklat',
                'desc'    => 'Ditemukan serangan wereng pada batang padi bagian bawah, populasi tinggi.',
                'sev'     => 'medium',
                'days'    => 2,
            ],
            [
                'name'    => 'Siti Rahayu',
                'email'   => 'siti.cikampek@padiku.test',
                'nik'     => '3215010202850002',
                'phone'   => '081311110002',
                'lat'     => $lat + 0.001,
                'lon'     => $lon + 0.001,
                'area'    => 0.75,
                'variety' => 'IR64',
                'pest'    => 'Tikus Sawah',
                'desc'    => 'Ada serangan tikus pada malam hari, beberapa batang padi rusak parah.',
                'sev'     => 'high',
                'days'    => 1,
            ],
            [
                'name'    => 'Ahmad Fauzi',
                'email'   => 'ahmad.cikampek@padiku.test',
                'nik'     => '3215010303900003',
                'phone'   => '081311110003',
                'lat'     => $lat - 0.001,
                'lon'     => $lon - 0.001,
                'area'    => 2.00,
                'variety' => 'Mekongga',
                'pest'    => 'Penggerek Batang',
                'desc'    => 'Terlihat gejala sundep pada tanaman, beberapa anakan mati akibat penggerek.',
                'sev'     => 'medium',
                'days'    => 0,
            ],
        ];

        foreach ($petani as $i => $p) {
            // Buat atau ambil akun user petani
            $user = User::firstOrCreate(
                ['email' => $p['email']],
                [
                    'name'      => $p['name'],
                    'password'  => Hash::make('petani123'),
                    'user_type' => 'petani',
                    'nik'       => $p['nik'],
                    'phone'     => $p['phone'],
                    'address'   => 'Desa Cikampek Pusaka, Kec. Cikampek, Kab. Karawang',
                    'district'  => $kecamatan,
                    'village'   => $desaName,
                ]
            );

            // Buat atau ambil data lahan — location_name HARUS = nama desa agar cocok di algoritma
            $planting = Planting::firstOrCreate(
                ['user_id' => $user->id, 'location_name' => $desaName],
                [
                    'latitude'             => $p['lat'],
                    'longitude'            => $p['lon'],
                    'area_hectares'        => $p['area'],
                    'planting_date'        => now()->subDays(45 + $i * 5),
                    'rice_variety'         => $p['variety'],
                    'status'               => 'growing',
                    'expected_harvest_date'=> now()->addDays(45 - $i * 5),
                    'notes'                => 'Data lahan petani ' . $p['name'],
                ]
            );

            // Buat atau ambil laporan hama
            PestReport::firstOrCreate(
                ['user_id' => $user->id, 'planting_id' => $planting->id],
                [
                    'pest_type'   => $p['pest'],
                    'description' => $p['desc'],
                    'latitude'    => $p['lat'],
                    'longitude'   => $p['lon'],
                    'severity'    => $p['sev'],
                    'status'      => 'reported',
                    'report_date' => now()->subDays($p['days']),
                ]
            );

            $this->command->line("  ✅ {$p['name']} ({$p['email']})");
        }

        $this->command->newLine();
        $this->command->info('3 akun petani Cikampek Pusaka berhasil dibuat!');
        $this->command->table(
            ['No', 'Nama', 'Email', 'Password', 'Desa / Location Name'],
            [
                ['1', 'Budi Santoso', 'budi.cikampek@padiku.test',  'petani123', $desaName],
                ['2', 'Siti Rahayu',  'siti.cikampek@padiku.test',  'petani123', $desaName],
                ['3', 'Ahmad Fauzi',  'ahmad.cikampek@padiku.test', 'petani123', $desaName],
            ]
        );
        $this->command->warn('Buka halaman Monitoring Hama → peta Cikampek Pusaka seharusnya WASPADA (kuning)');
    }
}
