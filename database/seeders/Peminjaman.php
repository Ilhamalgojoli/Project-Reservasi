<?php

namespace Database\Seeders;

use App\Models\DataPeminjaman;
use App\Models\Prodi;
use App\Models\Ruangan;
use App\Models\Fakultas;
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
        $muatanList = [20, 30, 40, 50];

        // Buat 50 data peminjaman random
        for ($i = 1; $i <= 50; $i++) {
            $randomProdi = $prodis->random();
            $r = $ruangan->random();
            $jenis = $jenisPeminjaman[array_rand($jenisPeminjaman)];

            $tanggal = Carbon::today()->addDays(rand(0, 7));
            $hariIndo = $tanggal->locale('id')->translatedFormat('l'); // 'Senin', 'Selasa', 'Rabu', dll.

            $fakultasName = Fakultas::where('id', $randomProdi->fakultas_id)->value('fakultas');

            $jumlahWaktu = rand(2, 4);
            $startTime = Carbon::createFromTime(rand(7, 16), 30, 0);
            $startStr = $startTime->format('H:i');
            $endTime = $startTime->copy()->addMinutes(30 * $jumlahWaktu);
            $endStr = $endTime->format('H:i');

            $diffMinutes = $startTime->diffInMinutes($endTime);
            $durationText = '';
            if ($diffMinutes >= 60) {
                $hours = floor($diffMinutes / 60);
                $mins = $diffMinutes % 60;
                $durationText = $hours . ' Jam' . ($mins > 0 ? " $mins Menit" : '');
            } else {
                $durationText = "$diffMinutes Menit";
            }

            $data = DataPeminjaman::create([
                'user_identifier' => '12345' . $i,
                'fakultas' => $fakultasName,
                'prodi' => $randomProdi->prodi,
                'jenis_peminjaman' => $jenis,
                'email' => 'user' . $i . '@example.com',
                'kode_matkul' => $jenis === 'akademik' ? 'MAT' . rand(100, 999) : null,
                'lantai' => $r->lantai->lantai,
                'ruangan_id' => $r->id,
                'tanggal_peminjaman' => $tanggal->format('Y-m-d'),
                'hari' => $hariIndo,
                'muatan' => $muatanList[array_rand($muatanList)],
                'penanggung_jawab' => 'User ' . $i,
                'kontak_penanggung_jawab' => '0812' . rand(1000000, 9999999),
                'keterangan_peminjaman' => 'Kegiatan ' . ($jenis === 'akademik' ? 'Perkuliahan' : 'Organisasi') . ' ' . $i,
                'status' => $i % 4 == 0 ? 'Waiting' : 'Approve',
                'waktu_mulai' => $startStr,
                'waktu_selesai' => $endStr,
                'total_waktu' => $durationText,
            ]);
        }
    }
}
