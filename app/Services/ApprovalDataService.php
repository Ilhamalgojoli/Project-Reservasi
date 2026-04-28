<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use Carbon\Carbon;

class ApprovalDataService
{
    public function getData($search)
    {
        $data_peminjaman = DataPeminjaman::with([
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',

            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'fakultas',
            'prodi',
        ])->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'ruangan_id', 'tanggal_peminjaman', 'status')
            ->where('status', 'Waiting')
            ->when($search, function ($query) use ($search) {
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
            })->paginate(10);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';
            $r->fakultas = $r->fakultas?->fakultas ?? '-';
            $r->prodi = $r->prodi?->prodi ?? '-';

            if ($r->waktuPeminjaman->isNotEmpty()) {
                $waktu = $r->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
                $start = Carbon::parse($waktu->first()->waktu_peminjaman);
                $end = Carbon::parse($waktu->last()->waktu_peminjaman);

                $r->jam_mulai = $start->format('H:i');
                $r->jam_selesai = $end->format('H:i');
                $r->total_menit = $waktu->count() * 30 - 30;
            } else {
                $r->jam_mulai = '-';
                $r->jam_selesai = '-';
                $r->total_menit = 0;
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
        ])->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'email', 'kontak_penanggung_jawab', 'fakultas_id', 'prodi_id', 'keterangan_peminjaman', 'ruangan_id', 'muatan', 'tanggal_peminjaman', 'status', 'kode_matkul')
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
