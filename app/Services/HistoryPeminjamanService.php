<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use Carbon\Carbon;

class HistoryPeminjamanService
{
    public function getDataUser($nim)
    {
        $data_peminjaman = DataPeminjaman::with([
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'fakultas',
            'prodi',
        ])
            ->where('user_identifier', $nim)
            ->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'fakultas_id', 'prodi_id', 'keterangan_peminjaman', 'ruangan_id', 'muatan', 'status', 'alasan_penolakan', 'tanggal_peminjaman')
            ->paginate(10);

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
        }

        return $data_peminjaman;
    }

    public function getDataAdmin()
    {
        $data_peminjaman = DataPeminjaman::with([
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'fakultas',
            'prodi',
        ])
            ->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'fakultas_id', 'prodi_id', 'keterangan_peminjaman', 'ruangan_id', 'muatan', 'status', 'alasan_penolakan', 'tanggal_peminjaman')
            ->paginate(10);

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
        }

        return $data_peminjaman;
    }
}
