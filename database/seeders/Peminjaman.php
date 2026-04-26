<?php

namespace Database\Seeders;

use App\Models\DataPeminjaman;
use App\Models\WaktuPeminjaman;
use App\Models\Prodi;
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
        $jenisPeminjaman = ['akademik', 'non-akademik'];
        $ruanganList = range(1, 40);
        $lantaiList = [1, 2, 3, 4];
        $muatanList = [20, 30, 40, 50];

        // Buat 10 data peminjaman random
        for ($i = 1; $i <= 20; $i++) {
            $randomProdi = $prodis->random();
            $data = DataPeminjaman::create([
                'user_identifier' => '12345' . $i, // 🔥 WAJIB
                'fakultas_id' => $randomProdi->fakultas_id,
                'prodi_id' => $randomProdi->id,
                'jenis_peminjaman' => $jenisPeminjaman[array_rand($jenisPeminjaman)],
                'email' => 'rilhamgojali123@gmail.com',
                'kode_matkul' => 'MAT' . rand(100, 999),
                'lantai' => $lantaiList[array_rand($lantaiList)],
                'ruangan_id' => $ruanganList[array_rand($ruanganList)],
                'tanggal_peminjaman' => Carbon::today()->addDays(rand(0, 5))->format('Y-m-d'),
                'muatan' => $muatanList[array_rand($muatanList)],
                'penanggung_jawab' => 'User ' . $i,
                'kontak_penanggung_jawab' => '0812' . rand(1000000, 9999999),
                'keterangan_peminjaman' => 'Keterangan contoh ' . $i,
                'status' => $i % 3 == 0 ? 'Approve' : 'Waiting',
            ]);

            // Buat 2-4 waktu peminjaman per data
            $jumlahWaktu = rand(2, 4);
            $startTime = Carbon::createFromTime(7, 0, 0); // jam 07:00
            for ($j = 0; $j < $jumlahWaktu; $j++) {
                WaktuPeminjaman::create([
                    'peminjaman_id' => $data->id,
                    'waktu_peminjaman' => $startTime->copy()->addMinutes(30 * $j)->format('H:i:s'),
                ]);
            }
        }
    }
}
