<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use App\MOdels\Monitor;
use App\Models\WaktuPeminjaman;
use Carbon\Carbon;

class ApprovalService
{
    public function approve($id)
    {
        $peminjaman = DataPeminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'Approve']);

        $waktu = WaktuPeminjaman::where('peminjaman_id', $peminjaman->id)
            ->orderBy('waktu_peminjaman')->get();

        $monitor = Monitor::create([
            'waktu_mulai' => $waktu->first()->waktu_peminjaman,
            'waktu_selesai' => $waktu->last()->waktu_peminjaman,
            'peminjaman_id' => $peminjaman->id,
        ]);
    }

    public function reject($id, $alasan)
    {
        $peminjaman = DataPeminjaman::findOrFail($id);
        $peminjaman->update([
            'status' => 'Reject',
            'alasan_penolakan' => $alasan,
        ]);

        WaktuPeminjaman::where('peminjaman_id', $id)->delete();
    }

    public function getData(string $page, $search = null)
    {
        $data_peminjaman = DataPeminjaman::with([
            // Waktu peminjaman
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',

            // Ruangan lantai dan gedung
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])->when($page === 'approvePage', function ($q) {
            $q->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'fakultas', 'prodi', 'keterangan_peminjaman', 'ruangan_id', 'muatan');
        })->when($page === 'historyPeminjaman', function ($q) {
            $q->select('id', 'jenis_peminjaman', 'penanggung_jawab', 'fakultas', 'prodi', 'keterangan_peminjaman', 'ruangan_id', 'muatan', 'status', 'alasan_penolakan');
        })->when($page === 'approvePage', function ($q) {
            $q->where('status', 'Waiting');
        })->when($search && $page === 'approvePage', function ($query) use($search){
            $query->where(function ($q) use($search){
                $q->where('jenis_peminjaman', 'like', "%{$search}%")
                    ->orWhere('penanggung_jawab', 'like', "%{$search}%");

                $q->orWhereHas('ruangan', function ($q2) use($search){
                    $q2->where('kode_ruangan', 'like', "%{$search}%")
                        ->orWhereHas('lantai.gedung', function ($q3) use($search) {
                            $q3->where('nama_gedung', 'like', "%{$search}%");
                        });
                });
            });
        })->paginate($page === 'approvePage' ? 5 : 10);

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
}
