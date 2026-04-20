<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id_role' => 38054,
                'role' => 'SUPERADMIN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 38055,
                'role' => 'BAA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 38056,
                'role' => 'PEGAWAI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 38057,
                'role' => 'ADMIN DATA MAHASISWA FAKULTAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 38059,
                'role' => 'ADMIN LAC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 38061,
                'role' => 'BK TEL-U',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 38062,
                'role' => 'KELOMPOK KEAHLIAN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 38063,
                'role' => 'ADMIN BK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 38064,
                'role' => 'DEVTEAM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 987229,
                'role' => 'STAFF URUSAN MANAJEMEN MUTU TEKNOLOGI INFORMASI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 295404,
                'role' => 'STAFF URUSAN PENGEMBANGAN STANDAR, METODE, DAN TEKNOLOGI PEMBELAJARAN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 987429,
                'role' => 'EXTERNAL AUDITOR',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 948523,
                'role' => 'KEPALA URUSAN ADMINISTRASI AKADEMIK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 1173292,
                'role' => 'ADMIN AKADEMIK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 1135890,
                'role' => 'KEPALA URUSAN ADMINISTRASI AKADEMIK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 1141824,
                'role' => 'ADMIN LAAK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_role' => 824030,
                'role' => 'DOSEN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}