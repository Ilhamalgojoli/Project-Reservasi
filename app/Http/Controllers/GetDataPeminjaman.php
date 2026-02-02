<?php

namespace App\Http\Controllers;
use App\Mdodels\DataPeminjaman;

class GetDataPeminjaman extends Controller
{
    public function getData(String $page)
    {
        $data_peminjaman = DataPeminjaman::with([
            // Waktu peminjaman
            'waktuPeminjaman:waktu_peminjaman,peminjaman_id',

            // Ruangan lantai dan gedung
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])->when($page)
            ->where('status', 'Waiting')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    // Query search dari table peminjaman
                    $q->where('jenis_peminjaman', 'like', "%{$this->search}%")
                        ->orWhere('penanggung_jawab', 'like', "%{$this->search}%");

                    // Query search dari table ruangan, lantai, gedung
                    $q->orWhereHas('ruangan', function ($q2) {
                        $q2->where('kode_ruangan', 'like', "%{$this->search}%")
                            ->orWhereHas('lantai.gedung', function ($q3) {
                                $q3->where('nama_gedung', 'like', "%{$this->search}%");
                            });
                    });
                });
            })
            ->paginate(5);

        info('query : ', $data_peminjaman->toArray());

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
