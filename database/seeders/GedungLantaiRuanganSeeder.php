<?php

namespace Database\Seeders;

use App\Models\Gedung;
use App\Models\Ruangan;
use App\Models\Lantai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ];

        foreach ($gedungNames as $g) {
            $gedung = Gedung::create([
                'nama_gedung' => $g['nama'],
                'kode_gedung' => $g['kode'],
                'keterangan' => 'Gedung ' . $g['nama'],
                'status' => 'Aktif'
            ]);

            // tiap gedung 2 lantai
            for ($l = 1; $l <= 2; $l++) {
                $lantai = Lantai::create([
                    'lantai' => $l,
                    'gedung_id' => $gedung->id,
                ]);

                // tiap lantai 2 ruangan
                for ($r = 1; $r <= 2; $r++) {
                    Ruangan::create([
                        'kode_ruangan' => $gedung->kode_gedung . '-L' . $l . '-R' . $r,
                        'status' => 'Aktif',
                        'muatan_kapasitas' => rand(20, 50),
                        'lantai_id' => $lantai->id,
                    ]);
                }
            }
        }
    }
}
