<?php

namespace Database\Seeders;

use App\Models\Gedung;
use App\Models\Ruangan;
use App\Models\Lantai;
use App\Models\Asset;
use Illuminate\Database\Seeder;

class GedungLantaiRuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gedungNames = [
            ['nama' => 'Gedung A', 'kode' => 'GA'],
            ['nama' => 'Gedung B', 'kode' => 'GB'],
            ['nama' => 'Gedung C', 'kode' => 'GC'],
            ['nama' => 'Gedung D', 'kode' => 'GD'],
            ['nama' => 'Gedung E', 'kode' => 'GE'],
            ['nama' => 'Gedung F', 'kode' => 'GF'],
        ];

        $status = ['Aktif', 'Tidak Aktif'];

        $assetNames = ['Meja', 'Kursi', 'Proyektor', 'AC', 'Lemari', 'Komputer'];
        $latitude = [-6.9731883607533, -6.9729061495641, -6.972938098009137];
        $longitude = [107.62945443391801, 107.62991577387, 107.62943834066];

        foreach ($gedungNames as $g) {
            $gedung = Gedung::create([
                'nama_gedung' => $g['nama'],
                'kode_gedung' => $g['kode'],
                'keterangan' => 'Gedung ' . $g['nama'],
                'status' => 'Aktif',
                'latitude' => $latitude[array_rand($latitude)],
                'longitude' => $longitude[array_rand($longitude)]
            ]);

            // tiap gedung 4 lantai
            for ($l = 1; $l <= 4; $l++) {
                $lantai = Lantai::create([
                    'lantai' => $l,
                    'gedung_id' => $gedung->id,
                ]);

                // tiap lantai 4 ruangan
                for ($r = 1; $r <= 4; $r++) {
                    $ruangan = Ruangan::create([
                        'kode_ruangan' => $gedung->kode_gedung . '-L' . $l . '-R' . $r,
                        'status' => $status[array_rand($status)],
                        'muatan_kapasitas' => rand(20, 50),
                        'lantai_id' => $lantai->id,
                    ]);

                    // tiap ruangan punya 1-3 asset random
                    $jumlahAsset = rand(1, 5);
                    for ($a = 1; $a <= $jumlahAsset; $a++) {
                        Asset::create([
                            'nama_asset' => $assetNames[array_rand($assetNames)],
                            'jumlah_asset' => rand(1, 10),
                            'ruangan_id' => $ruangan->id,
                        ]);
                    }
                }
            }
        }
    }
}