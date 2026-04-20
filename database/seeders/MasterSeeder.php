<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            FakultasProdi::class,
            GedungLantaiRuanganSeeder::class,
            Users::class,
            RoleSeeder::class,
            Peminjaman::class
        ]);
    }
}
