<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalMatkulWajib;
use App\Models\Ruangan;
use Illuminate\Support\Facades\File;

class JadwalMatkulWajibSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = base_path('Jadwal_Terstruktur.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error("File Jadwal_Terstruktur.json not found!");
            return;
        }

        $jsonData = json_decode(File::get($jsonPath), true);
        
        if (!$jsonData) {
            $this->command->error("Failed to decode JSON!");
            return;
        }

        $this->command->info("Seeding Jadwal Terstruktur...");

        // Get all ruangan for mapping
        $ruangans = Ruangan::pluck('id', 'kode_ruangan')->toArray();

        foreach ($jsonData as $hari => $lantais) {
            foreach ($lantais as $lantai => $schedules) {
                foreach ($schedules as $schedule) {
                    $ruanganCode = $schedule['Ruangan'];
                    $ruanganId = $ruangans[$ruanganCode] ?? null;

                    if (!$ruanganId) {
                        // Optionally log or print warning for missing rooms
                        // $this->command->warn("Ruangan $ruanganCode not found in database.");
                        continue;
                    }

                    $shift = $schedule['Shift'];
                    $times = explode(' - ', $shift);
                    
                    if (count($times) !== 2) {
                        continue;
                    }

                    $mulai = $times[0];
                    $selesai = $times[1];

                    // Normalize time format to HH:mm:ss if necessary
                    $mulai = date('H:i:s', strtotime($mulai));
                    $selesai = date('H:i:s', strtotime($selesai));

                    JadwalMatkulWajib::create([
                        'hari' => $hari,
                        'ruangan_id' => $ruanganId,
                        'nama_matkul' => $schedule['Nama Mata Kuliah'],
                        'dosen' => $schedule['Dosen'],
                        'shift_mulai' => $mulai,
                        'shift_selesai' => $selesai,
                    ]);
                }
            }
        }

        $this->command->info("Jadwal Terstruktur seeded successfully.");
    }
}
