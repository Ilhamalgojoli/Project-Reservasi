<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use Carbon\Carbon;

class HistoryPeminjamanService
{
    public function getDataUser($nim, $page = 1, $search = '', $filterStatus = '', $filterJenis = '')
    {
        $query = DataPeminjaman::with([
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])
            ->where('user_identifier', $nim)
            ->whereIn('status', ['Finish', 'Canceled', 'Reject']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('penanggung_jawab', 'like', "%{$search}%")
                  ->orWhereHas('ruangan', fn($r) => $r->where('kode_ruangan', 'like', "%{$search}%"))
                  ->orWhereHas('ruangan.lantai.gedung', fn($r) => $r->where('nama_gedung', 'like', "%{$search}%"));
            });
        }

        if (!empty($filterStatus)) {
            $query->where('status', $filterStatus);
        }

        if (!empty($filterJenis)) {
            $query->where('jenis_peminjaman', $filterJenis);
        }

        $data_peminjaman = $query
            ->select('id', 'ruangan_id', 'status', 'tanggal_peminjaman', 'hari', 
            'jenis_peminjaman', 'penanggung_jawab', 'waktu_mulai', 'waktu_selesai')
            ->latest('updated_at')
            ->paginate(10, ['*'], 'page', $page);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';

            $r->jam_mulai = $r->waktu_mulai ? Carbon::parse($r->waktu_mulai)->format('H:i') : '-';
            $r->jam_selesai = $r->waktu_selesai ? Carbon::parse($r->waktu_selesai)->format('H:i') : '-';

            unset($r->ruangan);
        }

        return $data_peminjaman;
    }

    public function getDataAdmin($page = 1, $jenis_peminjaman = '', $search = '', $filterStatus = '')
    {
        $query = DataPeminjaman::with([
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])->whereIn('status', ['Finish', 'Canceled', 'Reject']);

        if (!empty($jenis_peminjaman)) {
            $query->where('jenis_peminjaman', $jenis_peminjaman);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('penanggung_jawab', 'like', "%{$search}%")
                  ->orWhereHas('ruangan', fn($r) => $r->where('kode_ruangan', 'like', "%{$search}%"))
                  ->orWhereHas('ruangan.lantai.gedung', fn($r) => $r->where('nama_gedung', 'like', "%{$search}%"));
            });
        }

        if (!empty($filterStatus)) {
            $query->where('status', $filterStatus);
        }

        $data_peminjaman = $query->select('id', 'penanggung_jawab', 'prodi', 'ruangan_id', 'status', 'tanggal_peminjaman',
        'fakultas', 'jenis_peminjaman', 'hari', 'waktu_mulai', 'waktu_selesai')
            ->latest('updated_at')
            ->paginate(10, ['*'], 'page', $page);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';
            $r->fakultas_name = $r->fakultas ?? '-';
            $r->prodi_name = $r->prodi ?? '-';

            $r->jam_mulai = $r->waktu_mulai ? Carbon::parse($r->waktu_mulai)->format('H:i') : '-';
            $r->jam_selesai = $r->waktu_selesai ? Carbon::parse($r->waktu_selesai)->format('H:i') : '-';

            unset($r->ruangan, $r->prodi);
        }

        return $data_peminjaman;
    }

    public function getDetail($id)
    {
        $data = DataPeminjaman::with([
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])
            ->find($id);

        if (!$data) 
            return null;

        $data->kode_ruangan = $data->ruangan?->kode_ruangan ?? '-';
        $data->nama_gedung = $data->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
        $data->lantai = $data->ruangan?->lantai?->lantai ?? '-';
        $data->fakultas_name = $data->fakultas ?? '-';
        $data->prodi_name = $data->prodi ?? '-';

        if ($data->waktu_mulai && $data->waktu_selesai) {
            $data->jam_mulai = Carbon::parse($data->waktu_mulai)->format('H:i');
            $data->jam_selesai = Carbon::parse($data->waktu_selesai)->format('H:i');
            $data->total_menit = Carbon::parse($data->waktu_mulai)->diffInMinutes(Carbon::parse($data->waktu_selesai));
        } else {
            $data->jam_mulai = '-';
            $data->jam_selesai = '-';
            $data->total_menit = 0;
        }

        return $data;
    }
}
