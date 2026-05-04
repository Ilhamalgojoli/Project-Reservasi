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
    public function updateStatusFinish(): void
    {
        $today = date('Y-m-d');
        $nowTime = date('H:i:s');

        # ID of past reservations still marked as 'Approve'
        $idsPast = DataPeminjaman::select('id')
            ->where('status', 'Approve')
            ->where('tanggal_peminjaman', '<', $today)
            ->pluck('id');

        # ID of today's reservations that have ended (plus 30 min buffer)
        $idsToday = DataPeminjaman::select('id')
            ->where('status', 'Approve')
            ->where('tanggal_peminjaman', $today)
            ->whereNotExists(function ($query) use ($nowTime) {
                $query->select(DB::raw(1))
                    ->from('waktu_peminjaman')
                    ->whereColumn('waktu_peminjaman.peminjaman_id', 'data_peminjaman.id')
                    ->whereRaw("DATE_ADD(waktu_peminjaman.waktu_peminjaman, INTERVAL 30 MINUTE) >= ?", [$nowTime]);
            })
            ->pluck('id');

        $allIds = $idsPast->merge($idsToday);

        if ($allIds->isNotEmpty()) {
            DataPeminjaman::whereIn('id', $allIds)->update(['status' => 'Finish']);
        }
    }

    public function ambilData(string $jenis)
    {
        $this->updateStatusFinish();

        $pageName = $jenis === 'akademik' ? 'pageAkademik' : 'pageNonAkademik';
        $today = Carbon::today()->toDateString();
        $limitDate = Carbon::today()->addDays(5)->toDateString();

        return DataPeminjaman::with([
            'fakultas',
            'prodi',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,lantai,gedung_id',
            'ruangan.lantai.gedung:id,nama_gedung',
            'waktuPeminjaman:peminjaman_id,waktu_peminjaman'
        ])
            ->select('id', 'penanggung_jawab', 'fakultas_id', 'prodi_id', 'ruangan_id', 'tanggal_peminjaman', 'status', 'jenis_peminjaman', 'kode_matkul', 'muatan', 'kontak_penanggung_jawab')
            ->where('jenis_peminjaman', $jenis)
            ->whereIn('status', ['Approve', 'Finish'])
            ->whereBetween('tanggal_peminjaman', [$today, $limitDate])
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
                    $item->status_display = 'Tidak Ada Jadwal';
                }

                $item->fakultas_name = $item->fakultas?->fakultas ?? '-';
                $item->prodi_name = $item->prodi?->prodi ?? '-';
                $item->nama_gedung = $item->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
                $item->kode_ruangan = $item->ruangan?->kode_ruangan ?? '-';

                unset($item->fakultas, $item->prodi, $item->ruangan, $item->waktuPeminjaman);

                return $item;
            });
    }

    public function getDataKegiatanTerkini(): array
    {
        return KegiatanTerkiniModel::select('pesan')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()->toArray();
    }

    public function getPeriodeOptions(): array
    {
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');

        if ($currentMonth >= 2 && $currentMonth <= 7) {
            $y = $currentYear;
            $sem = 'genap';
        } else {
            $y = $currentMonth == 1 ? $currentYear - 1 : $currentYear;
            $sem = 'ganjil';
        }

        $temp = [];
        for ($i = 0; $i < 6; $i++) {
            if ($sem === 'genap') {
                $temp["$y-genap"] = "Genap " . ($y - 1) . "/" . $y;
                $sem = 'ganjil';
                $y--;
            } else {
                $temp["$y-ganjil"] = "Ganjil " . $y . "/" . ($y + 1);
                $sem = 'genap';
            }
        }

        $options = ['' => 'Semua Periode'];
        foreach (array_reverse($temp, true) as $k => $v) {
            $options[$k] = $v;
        }

        return $options;
    }

    private function applyPeriodeFilter($query, ?string $periode)
    {
        if (!$periode) return $query;
        
        $parts = explode('-', $periode);
        if (count($parts) !== 2) return $query;
        
        $year = $parts[0];
        $semester = $parts[1];

        if ($semester === 'genap') {
            $start = $year . '-02-01';
            $end = $year . '-06-31';
        } else {
            $start = $year . '-09-01';
            $end = ($year + 1) . '-01-31';
        }

        if ($query->getModel() instanceof DataPeminjaman) {
             return $query->whereBetween('data_peminjaman.tanggal_peminjaman', [$start, $end]);
        }
        
        return $query->whereBetween('tanggal_peminjaman', [$start, $end]);
    }

    public function getRuanganWaiting(?string $periode = null): int
    {
        $query = DataPeminjaman::where('status', 'Waiting');
        return $this->applyPeriodeFilter($query, $periode)->count();
    }

    public function getRuanganTerpakai(?string $periode = null): int
    {
        return Ruangan::whereHas('dataPeminjaman', function ($q) use ($periode) {
            $q->whereIn('status', ['Approve', 'Finish']);
            $this->applyPeriodeFilter($q, $periode);
        })->count();
    }

    public function getRuanganTersedia(int $occupiedCount): int
    {
        return Ruangan::count() - $occupiedCount;
    }

    public function chartGedung(?string $periode = null): array
    {
        return Gedung::select('id', 'nama_gedung')
            ->withCount([
                'ruangan as totalWaiting' => function ($q) use ($periode) {
                    $q->whereHas('dataPeminjaman', function ($q) use ($periode) {
                        $q->where('status', 'Waiting');
                        $this->applyPeriodeFilter($q, $periode);
                    });
                },
                'ruangan as totalTerpakai' => function ($q) use ($periode) {
                    $q->whereHas('dataPeminjaman', function ($q) use ($periode) {
                        $q->whereIn('status', ['Approve', 'Finish']);
                        $this->applyPeriodeFilter($q, $periode);
                    });
                },
                'ruangan as totalRuangan',
            ])
            ->get()
            ->map(function ($i) {
                return [
                    'id' => $i->id,
                    'nama_gedung' => $i->nama_gedung,
                    'totalWaiting' => $i->totalWaiting,
                    'totalTerpakai' => $i->totalTerpakai,
                    'totalTersedia' => $i->totalRuangan - $i->totalTerpakai,
                ];
            })->toArray();
    }

    public function getDataOkkupansi(?string $periode = null): array
    {
        return Gedung::select('id', 'nama_gedung')
            ->withCount([
                'ruangan as totalRuanganTerpakai' => function ($q) use ($periode) {
                    $q->whereHas('dataPeminjaman', function ($q) use ($periode) {
                        $q->whereIn('status', ['Approve', 'Finish']);
                        $this->applyPeriodeFilter($q, $periode);
                    });
                },
                'ruangan as totalRuangan',
            ])
            ->get()
            ->map(function ($i) {
                $terpakai = $i->totalRuangan > 0 ? round(($i->totalRuanganTerpakai / $i->totalRuangan) * 100, 2) : 0;
                return [
                    'id' => $i->id,
                    'nama_gedung' => $i->nama_gedung,
                    'terpakai' => $terpakai,
                    'tidakTerpakai' => 100 - $terpakai,
                ];
            })->toArray();
    }

    public function getDataPeminjamanPerFakultas(?string $periode = null): array
    {
        return Fakultas::select('id', 'fakultas')
            ->withCount(['peminjaman as total' => function ($q) use ($periode) {
                $q->whereIn('status', ['Approve', 'Finish']);
                $this->applyPeriodeFilter($q, $periode);
            }])->get()->toArray();
    }
}
