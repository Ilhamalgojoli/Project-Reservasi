<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use Carbon\Carbon;

class DashboardUserService
{
    public function getTotal(string $nim)
    {
        return DataPeminjaman::where('user_identifier', $nim)->count();
    }

    public function getWaiting(string $nim)
    {
        return DataPeminjaman::where('user_identifier', $nim)->where('status', 'Waiting')->count();
    }

    public function getApprove(string $nim)
    {
        return DataPeminjaman::where('user_identifier', $nim)->where('status', 'Approve')->count();
    }

    public function getReject(string $nim)
    {
        return DataPeminjaman::where('user_identifier', $nim)->where('status', 'Reject')->count();
    }

    public function getCanceled(string $nim)
    {
        return DataPeminjaman::where('user_identifier', $nim)->where('status', 'Canceled')->count();
    }

    public function getRecentBookings(string $nim)
    {
        $data = DataPeminjaman::with([
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',
        ])
            ->where('user_identifier', $nim)
            ->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'keterangan_peminjaman', 'ruangan_id', 'muatan', 'status', 'created_at')
            ->latest()
            ->limit(5)
            ->get();

        foreach ($data as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung  = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai       = $r->ruangan?->lantai?->lantai ?? '-';

            if ($r->waktuPeminjaman->isNotEmpty()) {
                $waktu = $r->waktuPeminjaman->sortBy('waktu_peminjaman')->values();
                $r->jam_mulai   = Carbon::parse($waktu->first()->waktu_peminjaman)->format('H:i');
                $r->jam_selesai = Carbon::parse($waktu->last()->waktu_peminjaman)->format('H:i');
            } else {
                $r->jam_mulai   = '-';
                $r->jam_selesai = '-';
            }
        }

        return $data;
    }

    public function getDashboardData(string $nim): array
    {
        return [
            'total'    => $this->getTotal($nim),
            'waiting'  => $this->getWaiting($nim),
            'approve'  => $this->getApprove($nim),
            'reject'   => $this->getReject($nim),
            'canceled' => $this->getCanceled($nim),
            'recent'   => $this->getRecentBookings($nim),
        ];
    }
}
