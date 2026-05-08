<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use Carbon\Carbon;

class ApprovalDataService
{
    public function getData($search, $fakultas_id = null, $jenis_peminjaman = null, $hari = null)
    {
        $query = DataPeminjaman::with([
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'fakultas',
            'prodi',
        ])->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'ruangan_id', 'tanggal_peminjaman', 'status', 'hari', 'fakultas_id', 'prodi_id');

        $query->where('status', 'Waiting');

        if ($fakultas_id) {
            $query->where('fakultas_id', $fakultas_id);
        }

        if ($jenis_peminjaman) {
            $query->where('jenis_peminjaman', $jenis_peminjaman);
        }

        if ($hari) {
            $query->where('hari', $hari);
        }

        $data_peminjaman = $query->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('jenis_peminjaman', 'like', "%{$search}%")
                        ->orWhere('penanggung_jawab', 'like', "%{$search}%");

                    $q->orWhereHas('ruangan', function ($q2) use ($search) {
                        $q2->where('kode_ruangan', 'like', "%{$search}%")
                            ->orWhereHas('lantai.gedung', function ($q3) use ($search) {
                                $q3->where('nama_gedung', 'like', "%{$search}%");
                            });
                    });
                });
            })->latest()->paginate(10);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';
            $r->fakultas_name = $r->fakultas?->fakultas ?? '-';
            $r->prodi_name = $r->prodi?->prodi ?? '-';

            if ($r->waktuPeminjaman->isNotEmpty()) {
                $waktu = $r->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
                $start = Carbon::parse($waktu->first()->waktu_peminjaman);
                $end = Carbon::parse($waktu->last()->waktu_peminjaman);

                $r->jam_mulai = $start->format('H:i');
                $r->jam_selesai = $end->format('H:i');
            } else {
                $r->jam_mulai = '-';
                $r->jam_selesai = '-';
            }

            unset($r->ruangan, $r->waktuPeminjaman, $r->fakultas, $r->prodi);
        }

        return $data_peminjaman;
    }

    public function getApprovedData($search, $fakultas_id = null, $jenis_peminjaman = null, $hari = null)
    {
        $query = DataPeminjaman::with([
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'fakultas',
            'prodi',
        ])->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'ruangan_id', 'tanggal_peminjaman', 'status', 'hari', 'fakultas_id', 'prodi_id');

        $query->where('status', 'Approve');

        if ($fakultas_id) {
            $query->where('fakultas_id', $fakultas_id);
        }

        if ($jenis_peminjaman) {
            $query->where('jenis_peminjaman', $jenis_peminjaman);
        }

        if ($hari) {
            $query->where('hari', $hari);
        }

        $data_peminjaman = $query->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('jenis_peminjaman', 'like', "%{$search}%")
                        ->orWhere('penanggung_jawab', 'like', "%{$search}%");

                    $q->orWhereHas('ruangan', function ($q2) use ($search) {
                        $q2->where('kode_ruangan', 'like', "%{$search}%")
                            ->orWhereHas('lantai.gedung', function ($q3) use ($search) {
                                $q3->where('nama_gedung', 'like', "%{$search}%");
                            });
                    });
                });
            })->latest()->paginate(10);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';
            $r->fakultas_name = $r->fakultas?->fakultas ?? '-';
            $r->prodi_name = $r->prodi?->prodi ?? '-';

            if ($r->waktuPeminjaman->isNotEmpty()) {
                $waktu = $r->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
                $start = Carbon::parse($waktu->first()->waktu_peminjaman);
                $end = Carbon::parse($waktu->last()->waktu_peminjaman);

                $r->jam_mulai = $start->format('H:i');
                $r->jam_selesai = $end->format('H:i');
            } else {
                $r->jam_mulai = '-';
                $r->jam_selesai = '-';
            }

            unset($r->ruangan, $r->waktuPeminjaman, $r->fakultas, $r->prodi);
        }

        return $data_peminjaman;
    }

    public function getDetail($id)
    {
        $peminjaman = DataPeminjaman::with([
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'fakultas',
            'prodi',
        ])->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'email', 'kontak_penanggung_jawab', 'fakultas_id', 'prodi_id', 'keterangan_peminjaman', 'ruangan_id', 'muatan', 'tanggal_peminjaman', 'status', 'kode_matkul', 'hari')
            ->findOrFail($id);

        $peminjaman->kode_ruangan = $peminjaman->ruangan?->kode_ruangan ?? '-';
        $peminjaman->nama_gedung = $peminjaman->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
        $peminjaman->lantai = $peminjaman->ruangan?->lantai?->lantai ?? '-';
        $peminjaman->fakultas = $peminjaman->fakultas?->fakultas ?? '-';
        $peminjaman->prodi = $peminjaman->prodi?->prodi ?? '-';

        if ($peminjaman->waktuPeminjaman->isNotEmpty()) {
            $waktu = $peminjaman->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
            $start = Carbon::parse($waktu->first()->waktu_peminjaman);
            $end = Carbon::parse($waktu->last()->waktu_peminjaman);

            $peminjaman->jam_mulai = $start->format('H:i');
            $peminjaman->jam_selesai = $end->format('H:i');
            $peminjaman->total_menit = $waktu->count() * 30 - 30;
        } else {
            $peminjaman->jam_mulai = '-';
            $peminjaman->jam_selesai = '-';
            $peminjaman->total_menit = 0;
        }

        return $peminjaman;
    }
}
