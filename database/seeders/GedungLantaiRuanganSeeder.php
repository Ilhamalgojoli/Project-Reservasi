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
        // ====== SEED GEDUNG TOKONG NANAS (GKU) FROM JSON ======
        $jsonPath = base_path('Jadwal_Terstruktur.json');
        if (\Illuminate\Support\Facades\File::exists($jsonPath)) {
            $data = json_decode(\Illuminate\Support\Facades\File::get($jsonPath), true);
            
            $gku = Gedung::create([
                'nama_gedung' => 'Gedung Tokong Nanas',
                'kode_gedung' => 'GKU',
                'keterangan' => 'Gedung Kuliah Umum (Tokong Nanas)',
                'status' => 'Aktif',
                'latitude' => -6.9731883607533,
                'longitude' => 107.62945443391801,
            ]);

            $floorsCreated = [];
            $senin = $data['SENIN'] ?? [];
            
            foreach ($senin as $floorName => $roomList) {
                $floorNum = (int) str_replace('Lantai_', '', $floorName);
                
                if (!isset($floorsCreated[$floorNum])) {
                    $lantai = Lantai::create([
                        'lantai' => $floorNum,
                        'gedung_id' => $gku->id
                    ]);
                    $floorsCreated[$floorNum] = $lantai;
                } else {
                    $lantai = $floorsCreated[$floorNum];
                }

                $processedRooms = [];
                foreach ($roomList as $roomData) {
                    $roomCode = $roomData['Ruangan'];
                    if (in_array($roomCode, $processedRooms)) continue;

                    Ruangan::create([
                        'kode_ruangan' => $roomCode,
                        'lantai_id' => $lantai->id,
                        'status' => 'Aktif',
                        'muatan_kapasitas' => rand(30, 60),
                    ]);
                    $processedRooms[] = $roomCode;
                }
            }
        }
    }
}