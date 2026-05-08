<?php

namespace Database\Seeders;

use App\Models\DataPeminjaman;
use App\Models\WaktuPeminjaman;
use App\Models\Prodi;
use App\Models\Ruangan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Peminjaman extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodis = Prodi::all();
        $ruangan = Ruangan::with('lantai')->get();
        if ($ruangan->isEmpty()) return;

        $jenisPeminjaman = ['akademik', 'non-akademik'];
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $muatanList = [20, 30, 40, 50];

        // Buat 50 data peminjaman random
        for ($i = 1; $i <= 50; $i++) {
            $randomProdi = $prodis->random();
            $r = $ruangan->random();
            $jenis = $jenisPeminjaman[array_rand($jenisPeminjaman)];
            
            $data = DataPeminjaman::create([
                'user_identifier' => '12345' . $i,
                'fakultas_id' => $randomProdi->fakultas_id,
                'prodi_id' => $randomProdi->id,
                'jenis_peminjaman' => $jenis,
                'email' => 'user' . $i . '@example.com',
                'kode_matkul' => $jenis === 'akademik' ? 'MAT' . rand(100, 999) : null,
                'lantai' => $r->lantai->lantai,
                'ruangan_id' => $r->id,
                'tanggal_peminjaman' => Carbon::today()->addDays(rand(0, 7))->format('Y-m-d'),
                'hari' => $hariList[array_rand($hariList)],
                'muatan' => $muatanList[array_rand($muatanList)],
                'penanggung_jawab' => 'User ' . $i,
                'kontak_penanggung_jawab' => '0812' . rand(1000000, 9999999),
                'keterangan_peminjaman' => 'Kegiatan ' . ($jenis === 'akademik' ? 'Perkuliahan' : 'Organisasi') . ' ' . $i,
                'status' => $i % 4 == 0 ? 'Waiting' : 'Approve',
            ]);

            // Buat 2-4 waktu peminjaman per data
            $jumlahWaktu = rand(2, 4);
            $startTime = Carbon::createFromTime(rand(7, 16), 30, 0); 
            for ($j = 0; $j < $jumlahWaktu; $j++) {
                WaktuPeminjaman::create([
                    'peminjaman_id' => $data->id,
                    'waktu_peminjaman' => $startTime->copy()->addMinutes(30 * $j)->format('H:i:s'),
                ]);
            }
        }
    }
}
