<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\Models\Gedung;
use App\Models\KegiatanTerkiniModel;
use App\Models\Monitor;
use App\Models\Ruangan;
use Carbon\Carbon;

class DashboardService
{
    public function ambilData(string $jenis)
    {
        $pageName = $jenis === 'akademik'
            ? 'pageAkademik'
            : 'pageNonAkademik';

        $monitor = Monitor::with([
            'peminjaman:id,fakultas,prodi,kode_matkul,lantai,ruangan_id,tanggal_peminjaman,muatan,kontak_penanggung_jawab,penanggung_jawab',
            'peminjaman.ruangan:id,kode_ruangan,lantai_id',
            'peminjaman.ruangan.lantai:id,lantai,gedung_id',
            'peminjaman.ruangan.lantai.gedung:id,nama_gedung',
        ])->whereHas('peminjaman', function ($q) use ($jenis) {
            $q->where('jenis_peminjaman', $jenis);
        })
            ->select('waktu_mulai', 'waktu_selesai', 'peminjaman_id', 'status')
            ->where('status', 'Di jadwalkan')
            ->paginate(5, ['*'], $pageName)
            ->through(function ($item) {
                $now = Carbon::now();
                $end = Carbon::parse($item->waktu_selesai);

                $item->sisa_detik = $now->lt($end)
                    ? $now->diffInSeconds($end)
                    : 0;

                return $item;
            });

        return $monitor;
    }

    public function getDataKegiatanTerkini()
    {
        $data = KegiatanTerkiniModel::select('pesan')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return $data;
    }

    public function getRuanganWaiting()
    {
        return $data = DataPeminjaman::where('status', 'Waiting')->count();
    }

    public function getRuanganTerpakai()
    {
        return $data = Ruangan::whereHas('dataPeminjaman', function ($q) {
            $q->where('status', 'Approve');
        })->count();
    }

    public function getRuanganTersedia($approve)
    {
        $totalRuangan = Ruangan::count();

        return $data = $totalRuangan - $approve;
    }

    public function chartGedung()
    {
        $data = Gedung::select('nama_gedung')
            ->withCount([
                'ruangan as totalWaiting' => function ($q) {
                    $q->whereHas('dataPeminjaman', function ($q) {
                        $q->where('status', 'Waiting');
                    });
                },

                'ruangan as totalTerpakai' => function ($q) {
                    $q->whereHas('dataPeminjaman', function ($q) {
                        $q->where('status', 'Approve');
                    });
                },
                'ruangan as totalRuangan',
            ])
            ->get()
            ->map(function ($i) {
                $i->totalTersedia = $i->totalRuangan - $i->totalTerpakai;

                return $i;
            });

        return $data;
    }

    public function getDataOkkupansi()
    {
        $data = Gedung::select('id', 'nama_gedung')
            ->withCount([
                'ruangan as totalRuanganTerpakai' => function ($q) {
                    $q->whereHas('dataPeminjaman', function ($q) {
                        $q->where('status', 'Approve');
                    });
                },
                'ruangan as totalRuanganTidakTerpakai' => function ($q) {
                    $q->whereDoesntHave('dataPeminjaman', function ($q) {
                        $q->where('status', 'Approve');
                    });
                },
                'ruangan as totalRuangan',
            ])
            ->get()
            ->map(function ($i) {
                $i->terpakai = $i->totalRuangan > 0
                    ? ($i->totalRuanganTerpakai / $i->totalRuangan) * 100
                    : 0;
                $i->tidakTerpakai = $i->totalRuangan > 0
                    ? ($i->totalRuanganTidakTerpakai / $i->totalRuangan) * 100
                    : 0;

                return $i;
            });

        return $data;
    }
}
