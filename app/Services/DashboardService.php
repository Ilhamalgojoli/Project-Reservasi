<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\Models\Fakultas;
use App\Models\Gedung;
use App\Models\KegiatanTerkiniModel;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function updateStatusFinish()
    {
        $today = date('Y-m-d');
        $nowTime = date('H:i:s');

        Db::transaction(function () use ($today, $nowTime) {
            # Update data dari hari-hari sebelumnya
            DataPeminjaman::where('status', 'Approve')
                ->where('tanggal_peminjaman', '<', $today)
                ->update(['status' => 'Finish']);

            # Update data hari ini yang sudah selesai
            DataPeminjaman::where('status', 'Approve')
                ->where('tanggal_peminjaman', $today)
                ->whereNotExists(function ($query) use ($nowTime) {
                    $query->select(DB::raw(1))
                        ->from('waktu_peminjaman')
                        ->whereColumn('waktu_peminjaman.peminjaman_id', 'data_peminjaman.id')
                        ->whereRaw("DATE_ADD(waktu_peminjaman.waktu_peminjaman, INTERVAL 30 MINUTE) >= ?", [$nowTime]);
                })
                ->update(['status' => 'Finish']);
        });
    }

    public function ambilData(string $jenis)
    {
        $this->updateStatusFinish();
        $pageName = $jenis === 'akademik'
            ? 'pageAkademik'
            : 'pageNonAkademik';

        $today = Carbon::today()->toDateString();
        $threeDaysLater = Carbon::today()->addDays(5)->toDateString();

        return DataPeminjaman::with([
            'fakultas',
            'prodi',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,lantai,gedung_id',
            'ruangan.lantai.gedung:id,nama_gedung',
            'waktuPeminjaman:peminjaman_id,waktu_peminjaman'
        ])
            ->where('jenis_peminjaman', $jenis)
            ->where('status', 'Approve')
            ->whereBetween('tanggal_peminjaman', [$today, $threeDaysLater])
            ->orderBy('tanggal_peminjaman', 'asc')
            ->paginate(5, ['*'], $pageName)
            ->through(function ($item) {
                $waktu = $item->waktuPeminjaman->sortBy('waktu_peminjaman');

                if ($waktu->isNotEmpty()) {
                    $start = Carbon::parse($item->tanggal_peminjaman . ' ' . $waktu->first()->waktu_peminjaman);
                    $end = Carbon::parse($item->tanggal_peminjaman . ' ' . $waktu->last()->waktu_peminjaman)->addMinutes(30);

                    $item->waktu_mulai = $start->format('H:i');
                    $item->waktu_selesai = $end->format('H:i');

                    $now = Carbon::now();
                    $item->sisa_detik = $now->lt($end)
                        ? $now->diffInSeconds($end)
                        : 0;

                    if ($now->lt($start)) {
                        $item->status_display = 'Di Jadwalkan';
                    } elseif ($now->between($start, $end)) {
                        $item->status_display = 'Sedang Berlangsung';
                    } else {
                        $item->status_display = 'Selesai';
                    }
                } else {
                    $item->waktu_mulai = '-';
                    $item->waktu_selesai = '-';
                    $item->sisa_detik = 0;
                    $item->status_display = 'Tidak Ada Jadwal';
                }

                $item->fakultas_name = $item->fakultas?->fakultas ?? '-';
                $item->prodi_name = $item->prodi?->prodi ?? '-';

                return $item;
            });
    }

    public function getDataKegiatanTerkini()
    {
        return KegiatanTerkiniModel::select('pesan')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
    }

    public function getRuanganWaiting()
    {
        return DataPeminjaman::where('status', 'Waiting')->count();
    }

    public function getRuanganTerpakai()
    {
        return Ruangan::whereHas('dataPeminjaman', function ($q) {
            $q->where('status', 'Approve');
        })->count();
    }

    public function getRuanganTersedia($approve)
    {
        $totalRuangan = Ruangan::count();

        return $totalRuangan - $approve;
    }

    public function chartGedung()
    {
        return Gedung::select('id', 'nama_gedung')
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
    }

    public function getDataOkkupansi()
    {
        return Gedung::select('id', 'nama_gedung')
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
    }

    public function getDataPeminjamanPerFakultas()
    {
        return Fakultas::select('id', 'fakultas')
            ->withCount(['peminjaman as total' => function ($q) {
                $q->where('status', 'Approve');
            }])->get();
    }
}
