<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user for Dinas Pertanian
        User::create([
            'name' => 'Admin PADIKU',
            'email' => 'adminpadiku@gmail.com',
            'password' => bcrypt('adminpadiku'),
            'user_type' => 'dinas_pertanian',
            'phone' => '081234567890',
            'address' => 'Kantor Dinas Pertanian Kabupaten Karawang',
            'district' => 'Karawang',
        ]);

        // Create test farmer users based on requested data
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.cikampek@padiku.test',
            'password' => bcrypt('petani123'),
            'user_type' => 'petani',
            'phone' => '081234567891',
            'address' => 'Cikampek Pusaka',
            'district' => 'Cikampek',
        ]);

        User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti.cikampek@padiku.test',
            'password' => bcrypt('petani123'),
            'user_type' => 'petani',
            'phone' => '081234567892',
            'address' => 'Cikampek Pusaka',
            'district' => 'Cikampek',
        ]);

        User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad.cikampek@padiku.test',
            'password' => bcrypt('petani123'),
            'user_type' => 'petani',
            'phone' => '081234567893',
            'address' => 'Cikampek Pusaka',
            'district' => 'Cikampek',
        ]);
    }
}
