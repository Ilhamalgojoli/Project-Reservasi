<?php

namespace App\Services;

use App\Models\DataPeminjaman;

use Carbon\Carbon;

class HistoryPeminjamanService
{
    public function getData($user, $nim)
    {
        $data_peminjaman = DataPeminjaman::with([
            // Waktu peminjaman
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',

            // Ruangan lantai dan gedung
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])->when($user === 'SUPERADMIN' || $user === 'KEPALA URUSAN ADMINISTRASI AKADEMIK', function ($q) {
            $q->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'fakultas', 'prodi', 'keterangan_peminjaman', 'ruangan_id', 'muatan', 'status', 'alasan_penolakan', 'alasan_pembatalan', 'cancel_by');
        })->when(($user === 'MAHASISWA' || $user === 'DOSEN') && $nim != null, function ($q) use ($nim) {
            $q->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'fakultas', 'prodi', 'keterangan_peminjaman', 'ruangan_id', 'muatan', 'status', 'alasan_penolakan');
            $q->where('user_identifier', $nim);
        })->paginate(10);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';

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

    public function cancel(array $data)
    {
        $data_peminjaman = DataPeminjaman::findOrFail($data['id']);

        \Log::info('data : ' , $data);

        switch ($data['user_role']) {
            case 'DOSEN':
            case 'MAHASISWA':
                // Cek user siapa request dan data mana yang akan dicancel
                if ($data_peminjaman->user_identifier != $data['user_identifier']) {
                    throw new \DomainException('Anda tidak berhak membatalkan peminjaman ini.');
                }

                if ($data_peminjaman->status != 'Waiting') {
                    throw new \DomainException('Anda tidak bisa membatalkan peminjaman ini.');
                }

                $data_peminjaman->update([
                    'status' => 'Canceled',
                    'alasan_pembatalan' => $data['alasan'],
                    'cancel_by' => $data['user_identifier']
                ]);

                break;
            case 'SUPERADMIN':
            case 'KEPALA URUSAN ADMINISTRASI AKADEMIK':
                $data_peminjaman->update([
                    'status' => 'Canceled',
                    'alasan_pembatalan' => $data['alasan'],
                    'cancel_by' => $data['user_identifier']
                ]);

                break;
            default:
                throw new \DomainException('Role tidak dikenali.');
                break;
        }
    }
}