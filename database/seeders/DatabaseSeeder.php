<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FakultasProdi::class,
            GedungLantaiRuanganSeeder::class,
            Users::class,
            RoleSeeder::class,
            Peminjaman::class,
            MatkulSeeder::class,
            JadwalMatkulWajibSeeder::class,
        ]);
    }
}
