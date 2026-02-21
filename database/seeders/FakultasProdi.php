<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Database\Seeder;

class FakultasProdi extends Seeder
{
    public function run()
    {
        $fakultasId = 1;
        $prodiId = 1;

        $data = [

            [
                'fakultas' => 'ILMU TERAPAN',
                'prodi' => [
                    'D3 Manajemen Pemasaran',
                    'D3 Rekayasa Perangkat Lunak Aplikasi',
                    'D3 Perhotelan',
                    'D3 Sistem Informasi Akuntansi',
                    'D3 Sistem Informasi',
                    'D4 Sistem Informasi Kota Cerdas',
                    'D3 Teknologi Telekomunikasi',
                    'D3 Teknologi Komputer',
                    'D4 Teknologi Rekayasa Multimedia',
                ],
            ],

            [
                'fakultas' => 'INDUSTRI KREATIF',
                'prodi' => [
                    'S1 Desain Produk',
                    'S1 Desain Interior',
                    'S1 Seni Rupa',
                    'S1 Desain Komunikasi Visual',
                    'S1 Kriya',
                    'S2 Desain',
                    'S1 Film',
                    'S1 Desain Komunikasi Visual (International Class)',
                    'S1 Desain Komunikasi Visual - Kampus Jakarta',
                ],
            ],

            [
                'fakultas' => 'TEKNIK ELEKTRO',
                'prodi' => [
                    'S1 Teknik Biomedis',
                    'S1 Teknik Sistem Energi',
                    'S3 Teknik Elektro',
                    'S1 Teknik Telekomunikasi',
                    'S1 Teknik Elektro',
                    'S2 Teknik Elektro',
                    'S1 Teknik Komputer',
                    'S1 Teknik Fisika',
                    'S1 Teknik Telekomunikasi - Kampus Jakarta',
                ],
            ],

            [
                'fakultas' => 'REKAYASA INDUSTRI',
                'prodi' => [
                    'S1 Sistem Informasi',
                    'S1 Sistem Informasi - Kampus Jakarta',
                    'S1 Teknik Logistik',
                    'S1 Teknik Industri',
                    'S2 Sistem Informasi',
                    'S2 Teknik Industri',
                    'S1 Manajemen Rekayasa',
                ],
            ],

            [
                'fakultas' => 'INFORMATIKA',
                'prodi' => [
                    'S2 Informatika',
                    'S1 Teknologi Informasi - Kampus Jakarta',
                    'S1 PJJ Informatika',
                    'S1 Informatika',
                    'S2 Ilmu Forensik',
                    'S3 Informatika',
                    'S1 Rekayasa Perangkat Lunak',
                    'S1 Sains Data',
                    'S1 Teknologi Informasi',
                ],
            ],

            [
                'fakultas' => 'EKONOMI DAN BISNIS',
                'prodi' => [
                    'S2 Manajemen',
                    'S1 Administrasi Bisnis (International Class)',
                    'S1 Manajemen (Manajemen Bisnis Telekomunikasi & Informatika)',
                    'S1 Akuntansi (International Class)',
                    'S1 Manajemen Bisnis Rekreasi',
                    'S2 Akuntansi',
                    'S2 Administrasi Bisnis',
                    'S1 Akuntansi',
                    'S3 Manajemen',
                    'S1 Administrasi Bisnis',
                    'S2 Manajemen PJJ',
                    'S1 International ICT Business',
                    'S1 Bisnis Digital',
                ],
            ],

            [
                'fakultas' => 'KOMUNIKASI DAN ILMU SOSIAL',
                'prodi' => [
                    'S1 Ilmu Komunikasi (International Class)',
                    'S2 Ilmu Komunikasi',
                    'S1 Penyiaran Konten Digital',
                    'S1 Ilmu Komunikasi',
                    'S1 Hubungan Masyarakat',
                    'S1 Psikologi',
                ],
            ],

            [
                'fakultas' => 'DIREKTORAT KAMPUS SURABAYA',
                'prodi' => [
                    'S1 Teknik Elektro - Kampus Surabaya',
                    'S1 Sistem Informasi - Kampus Surabaya',
                    'S1 Rekayasa Perangkat Lunak - Kampus Surabaya',
                    'S1 Teknologi Informasi - Kampus Surabaya',
                    'S1 Teknik Logistik - Kampus Surabaya',
                    'S1 Teknik Telekomunikasi - Kampus Surabaya',
                    'S1 Bisnis Digital - Kampus Surabaya',
                    'S1 Sains Data - Kampus Surabaya',
                    'S1 Teknik Komputer - Kampus Surabaya',
                    'S1 Teknik Industri - Kampus Surabaya',
                    'S1 Informatika - Kampus Surabaya',
                ],
            ],

            [
                'fakultas' => 'DIREKTORAT KAMPUS PURWOKERTO',
                'prodi' => [
                    'S1 Teknik Telekomunikasi - Kampus Purwokerto',
                    'S1 Teknik Logistik - Kampus Purwokerto',
                    'S1 Sistem Informasi - Kampus Purwokerto',
                    'S1 Sains Data - Kampus Purwokerto',
                    'S1 Teknik Elektro - Kampus Purwokerto',
                    'S1 Bisnis Digital - Kampus Purwokerto',
                    'S1 Teknik Industri - Kampus Purwokerto',
                    'D3 Teknik Telekomunikasi - Kampus Purwokerto',
                    'S1 Desain Komunikasi Visual - Kampus Purwokerto',
                    'S1 Teknologi Pangan - Kampus Purwokerto',
                    'S1 Desain Produk - Kampus Purwokerto',
                    'S1 Rekayasa Perangkat Lunak - Kampus Purwokerto',
                    'S1 Teknik Informatika - Kampus Purwokerto',
                    'S1 Teknik Biomedis - Kampus Purwokerto',
                ],
            ],
        ];

        foreach ($data as $item) {

            Fakultas::create([
                'id' => $fakultasId,
                'fakultas' => $item['fakultas'],
            ]);

            foreach ($item['prodi'] as $prodi) {

                Prodi::create([
                    'id' => $prodiId,
                    'fakultas_id' => $fakultasId,
                    'prodi' => $prodi,
                ]);

                $prodiId++;
            }

            $fakultasId++;
        }
    }
}
