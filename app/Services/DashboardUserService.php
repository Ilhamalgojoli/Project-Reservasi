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

    public function getRecentBookings(string $nim)
    {
        $data = DataPeminjaman::with([
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'pembatalan'
        ])
            ->where('user_identifier', $nim)
            ->whereIn('status', ['Approve', 'Waiting'])
            ->select(
                'id', 
                'jenis_peminjaman', 
                'penanggung_jawab', 
                'keterangan_peminjaman', 
                'ruangan_id',
                'muatan', 
                'status', 
                'waktu_mulai', 
                'waktu_selesai', 
                'created_at'
            )
            ->latest()
            ->get();

        foreach ($data as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';
            $r->jam_mulai = $r->waktu_mulai ? Carbon::parse($r->waktu_mulai)->format('H:i') : '-';
            $r->jam_selesai = $r->waktu_selesai ? Carbon::parse($r->waktu_selesai)->format('H:i') : '-';
        }

        return $data;
    }

    public function getDashboardData(string $nim): array
    {
        # Jalankan sinkronisasi database (Finish) khusus untuk NIM user ini agar statistik selalu akurat
        app(DashboardService::class)->updateStatusFinish($nim);

        # Jalankan sinkronisasi database (Auto-Reject) khusus untuk NIM user ini agar statistik selalu akurat
        app(ApproveRejectService::class)->autoRejectExpire($nim);
        $usedRoom = app(DashboardService::class)->getRuanganTerpakai();
        $availableRoom = app(DashboardService::class)->getRuanganTersedia($usedRoom);

        return [
            'total' => $this->getTotal($nim),
            'waiting' => $this->getWaiting($nim),
            'approve' => $this->getApprove($nim),
            'reject' => $this->getReject($nim),
            'recent' => $this->getRecentBookings($nim),
            'roomInfo' => [
                'used' => $usedRoom,
                'total' => $usedRoom + $availableRoom,
                'available' => $availableRoom
            ]
        ];
    }
}
