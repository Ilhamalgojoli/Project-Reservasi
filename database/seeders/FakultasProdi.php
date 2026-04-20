<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Database\Seeder;

class FakultasProdi extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => '3',
                'name' => 'ILMU TERAPAN',
                'prodi' => [
                    ['id' => '51', 'name' => 'D3 Manajemen Pemasaran'],
                    ['id' => '32', 'name' => 'D3 Rekayasa Perangkat Lunak Aplikasi'],
                    ['id' => '54', 'name' => 'D3 Perhotelan'],
                    ['id' => '73', 'name' => 'D3 Sistem Informasi Akuntansi'],
                    ['id' => '72', 'name' => 'D3 Sistem Informasi'],
                    ['id' => '124', 'name' => 'D4 Sistem Informasi Kota Cerdas'],
                    ['id' => '14', 'name' => 'D3 Teknologi Telekomunikasi'],
                    ['id' => '71', 'name' => 'D3 Teknologi Komputer'],
                    ['id' => '33', 'name' => 'D4 Teknologi Rekayasa Multimedia'],
                ]
            ],
            [
                'id' => '4',
                'name' => 'INDUSTRI KREATIF',
                'prodi' => [
                    ['id' => '94', 'name' => 'S1 Desain Produk'],
                    ['id' => '93', 'name' => 'S1 Desain Interior'],
                    ['id' => '95', 'name' => 'S1 Seni Rupa'],
                    ['id' => '91', 'name' => 'S1 Desain Komunikasi Visual'],
                    ['id' => '92', 'name' => 'S1 Kriya'],
                    ['id' => '57', 'name' => 'S2 Desain'],
                    ['id' => '98', 'name' => 'S1 Film'],
                    ['id' => '97', 'name' => 'S1 Desain Komunikasi Visual  ( International Class )'],
                    ['id' => '109', 'name' => 'S1 Desain Komunikasi Visual - Kampus Jakarta'],
                ]
            ],
            [
                'id' => '5',
                'name' => 'TEKNIK ELEKTRO',
                'prodi' => [
                    ['id' => '29', 'name' => 'S1 Teknik Biomedis'],
                    ['id' => '101', 'name' => 'S1 Teknik Sistem Energi'],
                    ['id' => '111', 'name' => 'S3 Teknik Elektro'],
                    ['id' => '11', 'name' => 'S1 Teknik Telekomunikasi'],
                    ['id' => '12', 'name' => 'S1 Teknik Elektro'],
                    ['id' => '78', 'name' => 'S2 Teknik Elektro'],
                    ['id' => '13', 'name' => 'S1 Teknik Komputer'],
                    ['id' => '62', 'name' => 'S1 Teknik Fisika'],
                    ['id' => '105', 'name' => 'S1 Teknik Telekomunikasi - Kampus Jakarta'],
                ]
            ],
            [
                'id' => '6',
                'name' => 'REKAYASA INDUSTRI',
                'prodi' => [
                    ['id' => '22', 'name' => 'S1 Sistem Informasi'],
                    ['id' => '107', 'name' => 'S1 Sistem Informasi - Kampus Jakarta'],
                    ['id' => '60', 'name' => 'S1 Teknik Logistik'],
                    ['id' => '21', 'name' => 'S1 Teknik Industri'],
                    ['id' => '10', 'name' => 'S2 Sistem Informasi'],
                    ['id' => '80', 'name' => 'S2 Teknik Industri'],
                    ['id' => '139', 'name' => 'S1 Manajemen Rekayasa'],
                ]
            ],
            [
                'id' => '7',
                'name' => 'INFORMATIKA',
                'prodi' => [
                    ['id' => '77', 'name' => 'S2 Informatika'],
                    ['id' => '106', 'name' => 'S1 Teknologi Informasi - Kampus Jakarta'],
                    ['id' => '89', 'name' => 'S1 PJJ Informatika'],
                    ['id' => '31', 'name' => 'S1 Informatika'],
                    ['id' => '49', 'name' => 'S2 Ilmu Forensik'],
                    ['id' => '52', 'name' => 'S3 Informatika'],
                    ['id' => '61', 'name' => 'S1 Rekayasa Perangkat Lunak'],
                    ['id' => '30', 'name' => 'S1 Sains Data'],
                    ['id' => '38', 'name' => 'S1 Teknologi Informasi'],
                ]
            ],
            [
                'id' => '8',
                'name' => 'EKONOMI DAN BISNIS',
                'prodi' => [
                    ['id' => '79', 'name' => 'S2 Manajemen'],
                    ['id' => '46', 'name' => 'S1 Administrasi Bisnis ( International Class )'],
                    ['id' => '41', 'name' => 'S1 Manajemen (Manajemen Bisnis Telekomunikasi & Informatika)'],
                    ['id' => '58', 'name' => 'S1 Akuntansi ( International Class )'],
                    ['id' => '103', 'name' => 'S1 Manajemen Bisnis Rekreasi'],
                    ['id' => '110', 'name' => 'S2 Akuntansi'],
                    ['id' => '100', 'name' => 'S2 Administrasi Bisnis'],
                    ['id' => '42', 'name' => 'S1 Akuntansi'],
                    ['id' => '112', 'name' => 'S3 Manajemen'],
                    ['id' => '44', 'name' => 'S1 Administrasi Bisnis'],
                    ['id' => '85', 'name' => 'S2 Manajemen PJJ'],
                    ['id' => '40', 'name' => 'S1 International ICT Business'],
                    ['id' => '140', 'name' => 'S1 Bisnis Digital'],
                ]
            ],
            [
                'id' => '9',
                'name' => 'KOMUNIKASI DAN ILMU SOSIAL',
                'prodi' => [
                    ['id' => '48', 'name' => 'S1 Ilmu Komunikasi ( International Class )'],
                    ['id' => '99', 'name' => 'S2 Ilmu Komunikasi'],
                    ['id' => '102', 'name' => 'S1 Penyiaran Konten Digital'],
                    ['id' => '43', 'name' => 'S1 Ilmu Komunikasi'],
                    ['id' => '47', 'name' => 'S1 Hubungan Masyarakat'],
                    ['id' => '141', 'name' => 'S1 Psikologi'],
                ]
            ],
            [
                'id' => '10',
                'name' => 'DIREKTORAT KAMPUS SURABAYA',
                'prodi' => [
                    ['id' => '114', 'name' => 'S1 Teknik Elektro - Kampus Surabaya'],
                    ['id' => '117', 'name' => 'S1 Sistem Informasi - Kampus Surabaya'],
                    ['id' => '115', 'name' => 'S1 Rekayasa Perangkat Lunak - Kampus Surabaya'],
                    ['id' => '119', 'name' => 'S1 Teknologi Informasi - Kampus Surabaya'],
                    ['id' => '123', 'name' => 'S1 Teknik Logistik - Kampus Surabaya'],
                    ['id' => '116', 'name' => 'S1 Teknik Telekomunikasi - Kampus Surabaya'],
                    ['id' => '120', 'name' => 'S1 Bisnis Digital - Kampus Surabaya'],
                    ['id' => '122', 'name' => 'S1 Sains Data - Kampus Surabaya'],
                    ['id' => '113', 'name' => 'S1 Teknik Komputer - Kampus Surabaya'],
                    ['id' => '118', 'name' => 'S1 Teknik Industri - Kampus Surabaya'],
                    ['id' => '121', 'name' => 'S1 Informatika - Kampus Surabaya'],
                ]
            ],
            [
                'id' => '11',
                'name' => 'DIREKTORAT KAMPUS PURWOKERTO',
                'prodi' => [
                    ['id' => '127', 'name' => 'S1 Teknik Telekomunikasi - Kampus Purwokerto'],
                    ['id' => '136', 'name' => 'S1 Teknik Logistik - Kampus Purwokerto'],
                    ['id' => '131', 'name' => 'S1 Sistem Informasi - Kampus Purwokerto'],
                    ['id' => '137', 'name' => 'S1 Sains Data - Kampus Purwokerto'],
                    ['id' => '128', 'name' => 'S1 Teknik Elektro - Kampus Purwokerto'],
                    ['id' => '133', 'name' => 'S1 Bisnis Digital - Kampus Purwokerto'],
                    ['id' => '129', 'name' => 'S1 Teknik Industri - Kampus Purwokerto'],
                    ['id' => '125', 'name' => 'D3 Teknik Telekomunikasi - Kampus Purwokerto'],
                    ['id' => '130', 'name' => 'S1 Desain Komunikasi Visual - Kampus Purwokerto'],
                    ['id' => '135', 'name' => 'S1 Teknologi Pangan - Kampus Purwokerto'],
                    ['id' => '134', 'name' => 'S1 Desain Produk - Kampus Purwokerto'],
                    ['id' => '132', 'name' => 'S1 Rekayasa Perangkat Lunak - Kampus Purwokerto'],
                    ['id' => '126', 'name' => 'S1 Teknik Informatika - Kampus Purwokerto'],
                    ['id' => '138', 'name' => 'S1 Teknik Biomedis - Kampus Purwokerto'],
                ]
            ],
        ];

        foreach ($data as $item) {
            Fakultas::updateOrCreate(
                ['id' => $item['id']],
                ['fakultas' => $item['name']]
            );

            foreach ($item['prodi'] as $prodi) {
                Prodi::updateOrCreate(
                    ['id' => $prodi['id']],
                    [
                        'fakultas_id' => $item['id'],
                        'prodi' => $prodi['name']
                    ]
                );
            }
        }
    }
}
