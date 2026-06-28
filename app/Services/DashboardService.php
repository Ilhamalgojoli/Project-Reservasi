<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\Models\Fakultas;
use App\Models\Gedung;
use App\Models\JadwalMatkulWajib;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function updateStatusFinish(?string $userIdentifier = null): void
    {
        $today = date('Y-m-d');
        $nowTime = date('H:i:s');

        # Ambil data peminjaman beberapa hari yang lalu
        $bookingPast = DataPeminjaman::select('id')
            ->where('status', 'Approve')
            ->where('tanggal_peminjaman', '<', $today);

        # Ambil data peminjaman untuk hari ini dan di jam yang sudah lewat
        $bookingNow = DataPeminjaman::select('id')
            ->where('status', 'Approve')
            ->where('tanggal_peminjaman', $today)
            ->where('waktu_selesai', '<', $nowTime);

        # Cek nim/nip pemilik kalau pemanggilan dari dashboard user  
        if ($userIdentifier) {
            $bookingPast->where('user_identifier', $userIdentifier);
            $bookingNow->where('user_identifier', $userIdentifier);
        }

        # Ambil id untuk sebelum dan sekarang
        $idPast = $bookingPast->pluck('id');
        $idToday = $bookingNow->pluck('id');

        # Gabung ke 2 data
        $allIds = $idPast->merge($idToday);

        # Cek var kosong atau tidak, kalau tidak kosong baru dan ada data nya, update data itu ke status finish
        if ($allIds->isNotEmpty()) {
            DataPeminjaman::whereIn('id', $allIds)->update(['status' => 'Finish']);
        }
    }

    # Ambil data peminjaman
    public function ambilData(string $jenis, ?string $lantai = null, ?string $status = null)
    {

        # Jalankan otomatis reject untuk peminjaman yang expired
        app(ApproveRejectService::class)->autoRejectExpire();

        $cardPage = $jenis === 'akademik' ? 'pageAkademik' : 'pageNonAkademik';
        $today = Carbon::today()->toDateString();
        $limitDate = Carbon::today()->addDays(5)->toDateString();

        $query = DataPeminjaman::with([
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,lantai,gedung_id',
            'ruangan.lantai.gedung:id,nama_gedung',
            'mataKuliah:kode_matkul,nama_matkul'
        ])
            ->select(
                'id',
                'penanggung_jawab',
                'fakultas',
                'prodi',
                'ruangan_id',
                'tanggal_peminjaman',
                'status',
                'jenis_peminjaman',
                'kode_matkul',
                'muatan',
                'kontak_penanggung_jawab',
                'hari',
                'lantai',
                'waktu_mulai',
                'waktu_selesai'
            )
            ->where('jenis_peminjaman', $jenis)
            ->whereIn('status', ['Approve', 'Finish'])
            ->whereBetween('tanggal_peminjaman', [$today, $limitDate]);

        if ($lantai) {
            $query->whereHas('ruangan.lantai', function ($q) use ($lantai) {
                $q->where('lantai', $lantai);
            });
        }

        $query = $this->applyStatusFilter($query, $status);

        return $query->orderBy('tanggal_peminjaman', 'asc')
            ->paginate(10, ['*'], $cardPage)
            ->through(fn($item) => $this->formatPeminjamanItem($item));
    }

    # Untuk filter status peminjaman di table monitor
    private function applyStatusFilter($query, ?string $status)
    {
        if (!$status) {
            return $query;
        }

        $now = Carbon::now();
        $nowDate = $now->toDateString();
        $nowTime = $now->format('H:i:s');

        if ($status === 'Di Jadwalkan') {
            return $query->where(function ($q) use ($nowDate, $nowTime) {
                $q->where('tanggal_peminjaman', '>', $nowDate)
                    ->orWhere(function ($q2) use ($nowDate, $nowTime) {
                        $q2->where('tanggal_peminjaman', '=', $nowDate)
                            ->where('waktu_mulai', '>', $nowTime);
                    });
            });
        }

        if ($status === 'Sedang Berlangsung') {
            return $query->where('tanggal_peminjaman', '=', $nowDate)
                ->where('waktu_mulai', '<=', $nowTime)
                ->where('waktu_selesai', '>=', $nowTime);
        }

        if ($status === 'Selesai') {
            return $query->where(function ($q) use ($nowDate, $nowTime) {
                $q->where('tanggal_peminjaman', '<', $nowDate)
                    ->orWhere(function ($q2) use ($nowDate, $nowTime) {
                        $q2->where('tanggal_peminjaman', '=', $nowDate)
                            ->where('waktu_selesai', '<', $nowTime);
                    });
            });
        }

        return $query;
    }

    # Format/transformasikan item peminjaman untuk representasi UI.
    private function formatPeminjamanItem($item)
    {
        if ($item->waktu_mulai && $item->waktu_selesai) {
            $start = Carbon::parse($item->tanggal_peminjaman . ' ' . $item->waktu_mulai);
            $end = Carbon::parse($item->tanggal_peminjaman . ' ' . $item->waktu_selesai);

            $item->waktu_mulai = Carbon::parse($item->waktu_mulai)->format('H:i');
            $item->waktu_selesai = Carbon::parse($item->waktu_selesai)->format('H:i');

            $this->formatStatus($start, $end, $item);
        } else {
            $item->waktu_mulai = '-';
            $item->waktu_selesai = '-';
            $item->status_display = 'Tidak Ada Jadwal';
        }

        $item->fakultas_name = $item->fakultas ?? '-';
        $item->prodi_name = $item->prodi ?? '-';
        $item->nama_gedung = $item->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
        $item->kode_ruangan = $item->ruangan?->kode_ruangan ?? '-';
        $item->nama_matkul = $item->mataKuliah?->nama_matkul ?? '-';

        unset($item->fakultas, $item->prodi, $item->ruangan, $item->mataKuliah);

        return $item;
    }

    # Mengambil data pemakaian ruang gedung untuk jadwal mata kuliah
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

        # Filter jadwal mata kuliah 
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

                $start = Carbon::parse(date('Y-m-d') . ' ' . $item->shift_mulai);
                $end = Carbon::parse(date('Y-m-d') . ' ' . $item->shift_selesai);

                $this->formatStatus($start, $end, $item);

                $item->nama_gedung = $item->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
                $item->kode_ruangan = $item->ruangan?->kode_ruangan ?? '-';
                $item->lantai_display = $item->ruangan?->lantai?->lantai ?? '-';

                return $item;
            });
    }

    private function formatStatus($start, $end, $item)
    {
        $now = Carbon::now();

        if ($now->lt($start)) {
            return $item->status_display = 'Di Jadwalkan';
        } elseif ($now->between($start, $end)) {
            return $item->status_display = 'Sedang Berlangsung';
        } else {
            return $item->status_display = 'Selesai';
        }
    }

    public function getPeriodeOptions(): array
    {
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        $sem = '';
        $y = '';

        if ($currentMonth >= 2 && $currentMonth <= 7) {
            $y = $currentYear;
            $sem = 'Genap';
        } else {
            $y = $currentMonth == 1 ? $currentYear - 1 : $currentYear;
            $sem = 'Ganjil';
        }

        $keyPeriodeSekarang = "$y - $sem";
        # Handle 1 tahun ke depan jika tahun 
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
        if (!$periode)
            return $query;

        $parts = explode('-', $periode);
        if (count($parts) !== 2)
            return $query;

        $year = trim($parts[0]);
        $semester = strtolower(trim($parts[1]));

        $start = "";
        $end = "";

        if ($semester === 'genap') {
            $start = $year . '-02-01';
            $end = $year . '-07-31';
        } else {
            $start = $year . '-08-01';
            $end = ($year + 1) . '-01-31';
        }

        # Cek apakah hasil query setiap pengolahan data pada setiap fungsi,itu adalaha eloquent BUILDER atau RAW SQL BUILDER
        if ($query instanceof \Illuminate\Database\Eloquent\Builder) {
            # Ambil model yang terikat dengan query yang dilakukan sebelum nya
            $model = $query->getModel();

            # Cek apakah model tersebut adalah data peminjaman atau tidak
            if ($model instanceof DataPeminjaman) {
                # Jika iya maka akan mengembalikan data peminjaman dengan rentang 
                return $query->whereBetween('data_peminjaman.tanggal_peminjaman', [$start, $end]);
            }
        }

        return $query->whereBetween('tanggal_peminjaman', [$start, $end]);
    }

    private function getCurrentDay(): string
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

        return $dayMapping[Carbon::now()->format('l')];
    }

    public function getRuanganWaiting(?string $periode = null): int
    {
        $query = DataPeminjaman::where('status', 'Waiting');
        return $this->applyPeriodeFilter($query, $periode)->count();
    }

    public function getRuanganTerpakai(?string $periode = null): int
    {
        $hariIni = $this->getCurrentDay();
        $waktuSekarang = Carbon::now()->format('H:i:s');

        # Ambil semua ruangan yang sudah pernah dipakai
        $peminjamanId = Ruangan::join('data_peminjaman', 'ruangans.id', '=', 'data_peminjaman.ruangan_id')
            ->where('data_peminjaman.status', 'Approve')
            ->when($periode, function ($q) use ($periode) {
                $this->applyPeriodeFilter($q, $periode);
            })
            ->distinct('ruangans.id')
            ->pluck('ruangans.id')
            ->toArray();

        # Ambil ruangan yang sedang dipakai dalam perkuliahan
        $matkulId = Ruangan::join('jadwal_matkul_wajib', 'ruangans.id', '=', 'jadwal_matkul_wajib.ruangan_id')
            ->where('jadwal_matkul_wajib.hari', $hariIni)
            ->where('jadwal_matkul_wajib.shift_mulai', '<=', $waktuSekarang)
            ->where('jadwal_matkul_wajib.shift_selesai', '>=', $waktuSekarang)
            ->distinct('ruangans.id')
            ->pluck('ruangans.id')
            ->toArray();

        return count(array_unique(array_merge($peminjamanId, $matkulId)));
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
                    $q->join('data_peminjaman', 'ruangans.id', '=', 'data_peminjaman.ruangan_id')
                        ->where('data_peminjaman.status', 'Waiting')
                        ->when($periode, function ($q2) use ($periode) {
                            $this->applyPeriodeFilter($q2, $periode);
                        });
                },
                'ruangan as totalTerpakai' => function ($q) use ($periode) {
                    $currentDay = $this->getCurrentDay();
                    $nowTime = Carbon::now()->format('H:i:s');
                    $q->where(function ($sub) use ($periode, $currentDay, $nowTime) {
                        # Ambil data ruangan per gedung yang terpakai berapa, dari data peminjaman
                        $sub->whereExists(function ($q2) use ($periode) {
                            $q2->select(DB::raw(1))
                                ->from('data_peminjaman')
                                ->whereColumn('data_peminjaman.ruangan_id', 'ruangans.id')
                                ->where('data_peminjaman.status', 'Approve')
                                ->when($periode, function ($q3) use ($periode) {
                                    $this->applyPeriodeFilter($q3, $periode);
                                });
                        })
                            # Ambil data ruangan per gedung yang terpakai berapa, dari data jadwal matakuliah
                            ->orWhereExists(function ($q3) use ($currentDay, $nowTime) {
                            $q3->select(DB::raw(1))
                                ->from('jadwal_matkul_wajib')
                                ->whereColumn('jadwal_matkul_wajib.ruangan_id', 'ruangans.id')
                                ->where('jadwal_matkul_wajib.hari', $currentDay)
                                ->where('jadwal_matkul_wajib.shift_mulai', '<=', $nowTime)
                                ->where('jadwal_matkul_wajib.shift_selesai', '>=', $nowTime);
                        });
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

    public function getDataOkkupansi(?string $periode = null, string $filter = 'semua'): array
    {
        $currentDay = $this->getCurrentDay();
        $nowTime = Carbon::now()->format('H:i:s');

        return Gedung::select('id', 'nama_gedung')
            ->withCount([
                'ruangan as totalRuanganTerpakai' => function ($q) use ($periode, $filter, $currentDay, $nowTime) {
                    # Filter data ruang gedung yang terpakai berdasarkan waktu jadwal peminjaman
                    if ($filter === 'peminjaman') {
                        $q->whereHas('dataPeminjaman', function ($q) use ($periode) {
                            $q->whereIn('status', ['Approve', 'Finish']);
                            $this->applyPeriodeFilter($q, $periode);
                        });
                    }
                    # Filter data ruang gedung yang terpakai berdasarkan waktu jadwal perkuliahan
                    elseif ($filter === 'perkuliahan') {
                        $q->whereIn('ruangans.id', function ($qSub) use ($currentDay, $nowTime) {
                            $qSub->select('ruangan_id')
                                ->from('jadwal_matkul_wajib')
                                ->where('hari', $currentDay)
                                ->where('shift_mulai', '<=', $nowTime)
                                ->where('shift_selesai', '>=', $nowTime);
                        });
                    } else {
                        # Filter semua data ruang gedung yang terpakai berdasarkan waktu jadwal peminjaman dan jadwal perkuliahan
                        $q->where(function ($sub) use ($periode, $currentDay, $nowTime) {
                            $sub->whereHas('dataPeminjaman', function ($q2) use ($periode) {
                                $q2->whereIn('status', ['Approve', 'Finish']);
                                $this->applyPeriodeFilter($q2, $periode);
                            })->orWhereIn('ruangans.id', function ($q3) use ($currentDay, $nowTime) {
                                $q3->select('ruangan_id')
                                    ->from('jadwal_matkul_wajib')
                                    ->where('hari', $currentDay)
                                    ->where('shift_mulai', '<=', $nowTime)
                                    ->where('shift_selesai', '>=', $nowTime);
                            });
                        });
                    }
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
                    'tidakTerpakai' => round(100 - $terpakai, 2),
                ];
            })->toArray();
    }

    public function getDataPeminjamanPerFakultas(?string $periode = null, string $filter = 'semua'): array
    {
        $fakultasData = Fakultas::select('id', 'fakultas')->get()->keyBy('id')->map(function ($f) {
            return [
                'id' => $f->id,
                'fakultas' => $f->fakultas,
                'total' => 0
            ];
        })->toArray();

        # Untuk data Peminjaman
        if ($filter === 'semua' || $filter === 'peminjaman') {
            $peminjamanCounts = Fakultas::select('id')
                ->withCount([
                    'peminjaman as total' => function ($q) use ($periode) {
                        $q->whereIn('status', ['Approve', 'Finish']);
                        $this->applyPeriodeFilter($q, $periode);
                    }
                ])
                ->get();

            foreach ($peminjamanCounts as $pc) {
                if (isset($fakultasData[$pc->id])) {
                    $fakultasData[$pc->id]['total'] += $pc->total;
                }
            }
        }

        # Untuk data Perkuliahan
        if ($filter === 'semua' || $filter === 'perkuliahan') {
            $query = DB::table('jadwal_matkul_wajib as j')
                ->join('mata_kuliah as m', 'j.nama_matkul', '=', 'm.nama_matkul')
                ->join('prodi as p', 'm.prodi_id', '=', 'p.id')
                ->select('p.fakultas_id', DB::raw('count(distinct j.id) as total_count'));

            if ($filter === 'perkuliahan') {
                $currentDay = $this->getCurrentDay();
                $query->where('j.hari', $currentDay);
            }

            $perkuliahanCounts = $query->groupBy('p.fakultas_id')->get();

            foreach ($perkuliahanCounts as $row) {
                $fakId = $row->fakultas_id;
                if (isset($fakultasData[$fakId])) {
                    $fakultasData[$fakId]['total'] += $row->total_count;
                }
            }
        }

        return array_values($fakultasData);
    }
}
