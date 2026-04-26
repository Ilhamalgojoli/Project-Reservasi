<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class HistoryPeminjamanService
{
    public function getDataUser($nim, $page = 1)
    {
        $data_peminjaman = DataPeminjaman::with([
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])
            ->where('user_identifier', $nim)
            ->select('id', 'ruangan_id', 'status', 'tanggal_peminjaman')
            ->latest()
            ->paginate(10, ['*'], 'page', $page);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';

            if ($r->waktuPeminjaman->isNotEmpty()) {
                $waktu = $r->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
                $r->jam_mulai = Carbon::parse($waktu->first()->waktu_peminjaman)->format('H:i');
                $r->jam_selesai = Carbon::parse($waktu->last()->waktu_peminjaman)->format('H:i');
            } else {
                $r->jam_mulai = '-';
                $r->jam_selesai = '-';
            }
        }

        return $data_peminjaman;
    }

    public function getDataAdmin($page = 1)
    {
        $data_peminjaman = DataPeminjaman::with([
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'prodi:id,prodi',
        ])
            ->select('id', 'penanggung_jawab', 'prodi_id', 'ruangan_id', 'status', 'tanggal_peminjaman')
            ->latest()
            ->paginate(10, ['*'], 'page', $page);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';
            $r->prodi = $r->prodi?->prodi ?? '-';

            if ($r->waktuPeminjaman->isNotEmpty()) {
                $waktu = $r->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
                $r->jam_mulai = Carbon::parse($waktu->first()->waktu_peminjaman)->format('H:i');
                $r->jam_selesai = Carbon::parse($waktu->last()->waktu_peminjaman)->format('H:i');
            } else {
                $r->jam_mulai = '-';
                $r->jam_selesai = '-';
            }
        }

        return $data_peminjaman;
    }

    public function getDetail($id)
    {
        $data = DataPeminjaman::with([
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'fakultas',
            'prodi',
        ])
            ->find($id);

        if (!$data) return null;

        $data->kode_ruangan = $data->ruangan?->kode_ruangan ?? '-';
        $data->nama_gedung = $data->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
        $data->lantai = $data->ruangan?->lantai?->lantai ?? '-';
        $data->fakultas_name = $data->fakultas?->fakultas ?? '-';
        $data->prodi_name = $data->prodi?->prodi ?? '-';

        if ($data->waktuPeminjaman->isNotEmpty()) {
            $waktu = $data->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
            $start = Carbon::parse($waktu->first()->waktu_peminjaman);
            $end = Carbon::parse($waktu->last()->waktu_peminjaman);

            $data->jam_mulai = $start->format('H:i');
            $data->jam_selesai = $end->format('H:i');
            $data->total_menit = $waktu->count() * 30 - 30;
        } else {
            $data->jam_mulai = '-';
            $data->jam_selesai = '-';
            $data->total_menit = 0;
        }

        return $data;
    }
}
