<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\Models\Fakultas;
use App\Models\Gedung;
use App\Models\KegiatanTerkiniModel;
use App\Models\JadwalMatkulWajib;
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
            'waktuPeminjaman:peminjaman_id,waktu_peminjaman',
            'mataKuliah:kode_matkul,nama_matkul'
        ])
            ->select('id', 'penanggung_jawab', 'fakultas_id', 'prodi_id', 'ruangan_id', 'tanggal_peminjaman', 'status', 'jenis_peminjaman', 'kode_matkul', 'muatan', 'kontak_penanggung_jawab', 'hari', 'lantai')
            ->where('jenis_peminjaman', $jenis)
            ->whereIn('status', ['Approve', 'Finish'])
            ->whereBetween('tanggal_peminjaman', [$today, $limitDate])
            ->orderBy('tanggal_peminjaman', 'asc')
            ->paginate(10, ['*'], $pageName)
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
                $item->nama_matkul = $item->mataKuliah?->nama_matkul ?? '-';

                unset($item->fakultas, $item->prodi, $item->ruangan, $item->waktuPeminjaman, $item->mataKuliah);

                return $item;
            });
    }

    public function ambilDataMatkulWajib(?string $lantai = null, ?string $status = null)
    {
        $dayMapping = [
            'Monday' => 'SENIN',
            'Tuesday' => 'SELASA',
            'Wednesday' => 'RABU',
            'Thursday' => 'KAMIS',
            'Friday' => 'JUMAT',
            'Saturday' => 'SABTU',
            'Sunday' => 'MINGGU',
        ];
        $currentDay = $dayMapping[Carbon::now()->format('l')];
        $nowTime = Carbon::now()->format('H:i:s');

        $query = JadwalMatkulWajib::with([
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,lantai,gedung_id',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])
            ->where('hari', $currentDay);

        if ($lantai) {
            $query->whereHas('ruangan.lantai', function ($q) use ($lantai) {
                $q->where('lantai', $lantai);
            });
        }

        if ($status) {
            if ($status === 'Di Jadwalkan') {
                $query->where('shift_mulai', '>', $nowTime);
            } elseif ($status === 'Sedang Berlangsung') {
                $query->where('shift_mulai', '<=', $nowTime)
                    ->where('shift_selesai', '>=', $nowTime);
            } elseif ($status === 'Selesai') {
                $query->where('shift_selesai', '<', $nowTime);
            }
        }

        return $query->paginate(10, ['*'], 'pageMatkulWajib')
            ->through(function ($item) {
                $item->waktu_mulai = Carbon::parse($item->shift_mulai)->format('H:i');
                $item->waktu_selesai = Carbon::parse($item->shift_selesai)->format('H:i');

                $now = Carbon::now();
                $start = Carbon::parse(date('Y-m-d') . ' ' . $item->shift_mulai);
                $end = Carbon::parse(date('Y-m-d') . ' ' . $item->shift_selesai);

                if ($now->lt($start)) {
                    $item->status_display = 'Di Jadwalkan';
                } elseif ($now->between($start, $end)) {
                    $item->status_display = 'Sedang Berlangsung';
                } else {
                    $item->status_display = 'Selesai';
                }

                $item->nama_gedung = $item->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
                $item->kode_ruangan = $item->ruangan?->kode_ruangan ?? '-';
                $item->lantai_display = $item->ruangan?->lantai?->lantai ?? '-';

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
            $sem = 'Genap';
        } else {
            $y = $currentMonth == 1 ? $currentYear - 1 : $currentYear;
            $sem = 'Ganjil';
        }
        $keyPeriodeSekarang = "$y - $sem";

        for ($j = 0; $j < 2; $j++) {
            if ($sem === 'Genap') {
                $sem = 'Ganjil';
            } else {
                $sem = 'Genap';
                $y++;
            }
        }

        $periode = [];
        for ($i = 0; $i < 6; $i++) {
            if ($sem === 'Genap') {
                $key = "$y - Genap";
                $val = "Semester Genap " . ($y - 1) . "/" . $y;
                $periode[$key] = $val;
                $sem = 'Ganjil';
                $y--;
            } else {
                $key = "$y - Ganjil";
                $val = "Semester Ganjil " . $y . "/" . ($y + 1);
                $periode[$key] = $val;
                $sem = 'Genap';
            }
        }

        $options = ['' => 'Pilih periode'];
        foreach ($periode as $key => $val) {
            $options[$key] = $val;
        }

        return [
            'options' => $options,
            'current' => $keyPeriodeSekarang
        ];
    }

    private function applyPeriodeFilter($query, ?string $periode)
    {
        if (!$periode) return $query;

        $parts = explode('-', $periode);
        if (count($parts) !== 2) return $query;

        $year = trim($parts[0]);
        $semester = strtolower(trim($parts[1]));

        if ($semester === 'genap') {
            $start = $year . '-02-01';
            $end = $year . '-07-31';
        } else {
            $start = $year . '-08-01';
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
