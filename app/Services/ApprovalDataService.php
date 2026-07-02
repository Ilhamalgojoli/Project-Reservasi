<?php

namespace App\Services;

use App\Models\DataPeminjaman;
use Carbon\Carbon;

class ApprovalDataService
{
    public function getData($search, $jenis_peminjaman = null, $hari = null)
    {
        $query = DataPeminjaman::with([
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
        ])->select(
            'id',
            'jenis_peminjaman',
            'penanggung_jawab',
            'ruangan_id',
            'tanggal_peminjaman',
            'waktu_mulai',
            'waktu_selesai',
            'status',
            'hari',
            'fakultas',
            'prodi'
        );

        $query->where('status', 'Waiting');

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
        })->latest('created_at')->paginate(10);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';
            $r->fakultas_name = $r->fakultas ?? '-';
            $r->prodi_name = $r->prodi ?? '-';

            $r->jam_mulai = $r->waktu_mulai ? Carbon::parse($r->waktu_mulai)->format('H:i') : '-';
            $r->jam_selesai = $r->waktu_selesai ? Carbon::parse($r->waktu_selesai)->format('H:i') : '-';

            unset($r->ruangan);
        }

        return $data_peminjaman;
    }

    public function getApprovedData($search, $jenis_peminjaman = null, $hari = null)
    {
        $query = DataPeminjaman::leftJoin('pembatalan_peminjaman', 'data_peminjaman.id', '=', 'pembatalan_peminjaman.data_peminjaman_id')
            ->with([
                'ruangan:id,kode_ruangan,lantai_id',
                'ruangan.lantai:id,gedung_id,lantai',
                'ruangan.lantai.gedung:id,nama_gedung',
                'pembatalan'
            ])
            ->select(
                'data_peminjaman.id',
                'data_peminjaman.jenis_peminjaman',
                'data_peminjaman.penanggung_jawab',
                'data_peminjaman.ruangan_id',
                'data_peminjaman.tanggal_peminjaman',
                'data_peminjaman.waktu_mulai',
                'data_peminjaman.waktu_selesai',
                'data_peminjaman.status',
                'data_peminjaman.hari',
                'data_peminjaman.fakultas',
                'data_peminjaman.prodi'
            );

        $query->where('data_peminjaman.status', 'Approve');

        if ($jenis_peminjaman) {
            $query->where('data_peminjaman.jenis_peminjaman', $jenis_peminjaman);
        }

        if ($hari) {
            $query->where('data_peminjaman.hari', $hari);
        }

        $data_peminjaman = $query->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('data_peminjaman.jenis_peminjaman', 'like', "%{$search}%")
                    ->orWhere('data_peminjaman.penanggung_jawab', 'like', "%{$search}%");

                $q->orWhereHas('ruangan', function ($q2) use ($search) {
                    $q2->where('kode_ruangan', 'like', "%{$search}%")
                        ->orWhereHas('lantai.gedung', function ($q3) use ($search) {
                            $q3->where('nama_gedung', 'like', "%{$search}%");
                        });
                });
            });
        })
            ->orderBy('pembatalan_peminjaman.cancel_requested', 'desc')
            ->orderBy('data_peminjaman.created_at', 'desc')
            ->paginate(10);

        foreach ($data_peminjaman as $r) {
            $r->kode_ruangan = $r->ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $r->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
            $r->lantai = $r->ruangan?->lantai?->lantai ?? '-';
            $r->fakultas_name = $r->fakultas ?? '-';
            $r->prodi_name = $r->prodi ?? '-';

            $r->jam_mulai = $r->waktu_mulai ? Carbon::parse($r->waktu_mulai)->format('H:i') : '-';
            $r->jam_selesai = $r->waktu_selesai ? Carbon::parse($r->waktu_selesai)->format('H:i') : '-';

            unset($r->ruangan);
        }

        return $data_peminjaman;
    }

    public function getDetail($id, $detailApprove = null)
    {
        $peminjaman = DataPeminjaman::with([
            'ruangan:id,kode_ruangan,lantai_id',
            'ruangan.lantai:id,gedung_id,lantai',
            'ruangan.lantai.gedung:id,nama_gedung',
            'pembatalan'
        ])->select(
            'id',
            'jenis_peminjaman',
            'penanggung_jawab',
            'email',
            'kontak_penanggung_jawab',
            'fakultas',
            'prodi',
            'keterangan_peminjaman',
            'ruangan_id',
            'muatan',
            'tanggal_peminjaman',
            'status',
            'kode_matkul',
            'hari',
            'waktu_mulai',
            'waktu_selesai',
            'alasan_penolakan',
            'dokumen',
            'nama_dokumen'
        )
            ->when($detailApprove === 'approvedDetail', function ($q) {
                $q->where('status', 'Approve');
            })
            ->findOrFail($id);

        $peminjaman->kode_ruangan = $peminjaman->ruangan?->kode_ruangan ?? '-';
        $peminjaman->nama_gedung = $peminjaman->ruangan?->lantai?->gedung?->nama_gedung ?? '-';
        $peminjaman->lantai = $peminjaman->ruangan?->lantai?->lantai ?? '-';
        $peminjaman->fakultas = $peminjaman->fakultas ?? '-';
        $peminjaman->prodi = $peminjaman->prodi ?? '-';

        if ($peminjaman->waktu_mulai && $peminjaman->waktu_selesai) {
            $peminjaman->jam_mulai = Carbon::parse($peminjaman->waktu_mulai)->format('H:i');
            $peminjaman->jam_selesai = Carbon::parse($peminjaman->waktu_selesai)->format('H:i');
            $peminjaman->total_menit = Carbon::parse($peminjaman->waktu_mulai)->diffInMinutes(Carbon::parse($peminjaman->waktu_selesai));
        } else {
            $peminjaman->jam_mulai = '-';
            $peminjaman->jam_selesai = '-';
            $peminjaman->total_menit = 0;
        }

        return $peminjaman;
    }
}
