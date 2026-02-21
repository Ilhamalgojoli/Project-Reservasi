<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\Models\Fakultas;
use App\Models\Gedung;
use App\Models\KegiatanTerkiniModel;
use App\Models\Lantai;
use App\Models\Prodi;
use App\Models\Ruangan;
use App\Models\WaktuPeminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanService
{
    public function getLantai($gedungId)
    {
        return Lantai::select('id', 'lantai')
            ->where('gedung_id', $gedungId)
            ->get();
    }

    public function getRuangan($lantaiId)
    {
        return Ruangan::select('id', 'kode_ruangan')
            ->where('status', 'Aktif')
            ->where('lantai_id', $lantaiId)
            ->get();
    }

    public function getFakultas()
    {
        return Fakultas::select('id', 'fakultas')
            ->get();
    }

    public function getProdi($fakultasID)
    {
        return Prodi::select('id', 'prodi')
            ->where('fakultas_id', $fakultasID)
            ->get();
    }

    public function getMaxKapasitas($ruanganId)
    {
        return Ruangan::where('id', $ruanganId)
            ->value('muatan_kapasitas');
    }

    public function getDataMap($gedungID)
    {
        return Gedung::select('latitude', 'longitude')
            ->where('id', $gedungID)
            ->first();
    }

    public function generateJam($start, $end, $interval = 30)
    {
        $result = [];
        [$h, $m] = explode(':', $start);
        [$endH, $endM] = explode(':', $end);
        $h = (int) $h;
        $m = (int) $m;
        $endH = (int) $endH;
        $endM = (int) $endM;

        while ($h < $endH || ($h === $endH && $m <= $endM)) {
            $result[] = sprintf('%02d:%02d', $h, $m);
            $m += $interval;
            if ($m >= 60) {
                $h++;
                $m -= 60;
            }
        }

        return $result;
    }

    public function create(array $data)
    {
        $this->cekTabrakanJadwal($data);
        $this->cekMuatan($data['ruanganID'], $data['muatanKapasitas']);

        return DB::transaction(function () use ($data) {
            $peminjaman = DataPeminjaman::create([
                'fakultas' => $data['fakultas'],
                'prodi' => $data['prodi'],
                'jenis_peminjaman' => $data['jenisPeminjaman'],
                'kode_matkul' => $data['kodeMatkul'] ?? null,
                'lantai' => (int) $data['lantaiID'],
                'ruangan_id' => (int) $data['ruanganID'],
                'tanggal_peminjaman' => $data['tanggal'],
                'muatan' => $data['muatanKapasitas'],
                'penanggung_jawab' => $data['penanggungJawab'],
                'kontak_penanggung_jawab' => $data['kontakPenanggungJawab'],
                'keterangan_peminjaman' => $data['deskripsi'],
            ]);

            foreach ($data['pilihJam'] as $waktu) {
                WaktuPeminjaman::create([
                    'waktu_peminjaman' => $waktu,
                    'peminjaman_id' => $peminjaman->id,
                ]);
            }

            return $peminjaman;
        });
    }

    protected function cekTabrakanJadwal(array $data)
    {
        $tabrakan = WaktuPeminjaman::whereHas('peminjaman', function ($q) use ($data) {
            $q->where('ruangan_id', $data['ruanganID'])
                ->where('tanggal_peminjaman', $data['tanggal']);
        })
            ->whereIn('waktu_peminjaman', $data['pilihJam'])
            ->orderBy('waktu_peminjaman')
            ->get();

        if ($tabrakan->isNotEmpty()) {
            $rangeDb = WaktuPeminjaman::whereHas('peminjaman', function ($q) use ($data) {
                $q->where('ruangan_id', $data['ruanganID'])->where('tanggal_peminjaman', $data['tanggal']);
            })->orderBy('waktu_peminjaman')->get();

            $start = Carbon::parse($rangeDb->first()->waktu_peminjaman);
            $end = Carbon::parse($rangeDb->last()->waktu_peminjaman);

            throw new \DomainException("Ruangan pada jam $start sudah dipakai sampai jam $end");
        }
    }

    protected function cekMuatan(int $ruanganID, int $kapasitas)
    {
        $over_cap = Ruangan::where('id', $ruanganID)
            ->value('muatan_kapasitas');

        if ($kapasitas >= $over_cap) {
            throw new \DomainException('Ruangan melebihi kapasitas');
        }
    }

    public function createKegiatan($penanggungJawab, $ruanganID)
    {
        if (! $ruanganID) {
            throw new \DomainException('Ruangan tidak ditemukan');
        }

        $ruangan = Ruangan::select('kode_ruangan')
            ->where('id', $ruanganID)
            ->first();

        KegiatanTerkiniModel::create([
            'pesan' => "$penanggungJawab melakukan peminjaman pada ruangan $ruangan->kode_ruangan",
        ]);
    }
}
