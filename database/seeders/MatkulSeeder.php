<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class MatkulSeeder extends Seeder
{
    /**
     * Seed mata kuliah dari file JSON IT dan Non-IT.
     * Setiap entry unik berdasarkan kombinasi kode_matkul + prodi_id.
     */
    public function run(): void
    {
        MataKuliah::truncate();

        $this->seedFromFile(
            base_path('Matkul_Per_Prodi_IT.json'),
            'IT'
        );

        $this->seedFromFile(
            base_path('Matkul_Per_Prodi_NonIT.json'),
            'Non-IT'
        );

        $this->command->info('MatkulSeeder selesai.');
        $this->command->info('Total mata kuliah: ' . MataKuliah::count());
    }

    /**
     * Baca file JSON dan insert ke tabel mata_kuliah.
     *
     * @param string $filePath  Path absolut ke file JSON
     * @param string $kategori  'IT' atau 'Non-IT'
     */
    private function seedFromFile(string $filePath, string $kategori): void
    {
        if (!file_exists($filePath)) {
            $this->command->warn("File tidak ditemukan: {$filePath}");
            return;
        }

        $raw  = file_get_contents($filePath);
        $data = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error("Gagal parse JSON ({$kategori}): " . json_last_error_msg());
            return;
        }

        $uniqueData = [];
        $now = now();

        foreach ($data as $prodiData) {
            $prodiId    = $prodiData['study_program_id'] ?? null;
            $mataKuliah = $prodiData['mata_kuliah']  ?? [];

            foreach ($mataKuliah as $mk) {
                $kodeMatkul = $mk['Kode Mata Kuliah'] ?? null;
                $namaMatkul = $mk['Nama Mata Kuliah'] ?? null;

                if (!$kodeMatkul || !$namaMatkul) {
                    continue;
                }

                $finalProdiId = str_starts_with($kodeMatkul, 'U') ? null : $prodiId;

                $key = $kodeMatkul . '-' . ($finalProdiId ?? 'MKU');
                
                if (!isset($uniqueData[$key])) {
                    $uniqueData[$key] = [
                        'kode_matkul' => $kodeMatkul,
                        'nama_matkul' => $namaMatkul,
                        'prodi_id'    => $finalProdiId,
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ];
                }
            }
        }

        // Insert dalam chunk
        $chunks = array_chunk(array_values($uniqueData), 100);
        foreach ($chunks as $chunk) {
            MataKuliah::insert($chunk);
        }

        $this->command->info("[{$kategori}] Berhasil seed " . count($uniqueData) . " baris mata kuliah.");
    }
}
