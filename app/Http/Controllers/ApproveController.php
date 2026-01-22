<?php

namespace App\Http\Controllers;

use App\Models\DataPeminjaman;
use App\Models\WaktuPeminjaman;
use App\Models\Ruangan;
use Carbon\Carbon;

class ApproveController extends Controller
{
    public function index()
    {
        $data_peminjaman = DataPeminjaman::with('waktuPeminjaman')->where('status', '=', 'Waiting')->get();
        $ruanganMap = Ruangan::join('lantais', 'lantais.id', '=', 'ruangans.lantai_id')
            ->join('gedungs', 'gedungs.id', '=', 'lantais.gedung_id')
            ->select(
                'ruangans.id',
                'ruangans.kode_ruangan',
                'gedungs.nama_gedung'
            )
            ->get()
            ->keyBy('id');

        foreach ($data_peminjaman as $r) {
            $ruangan = $ruanganMap[$r->ruangan];

            $r->kode_ruangan = $ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $ruangan?->nama_gedung ?? '-';

            if ($r->waktuPeminjaman->isNotEmpty()) {
                $waktu = $r->waktuPeminjaman
                    ->sortBy('waktu_peminjaman')
                    ->values();

                $start = Carbon::parse($waktu->first()->waktu_peminjaman);
                $end = Carbon::parse($waktu->last()->waktu_peminjaman);

                $total_slot = $waktu->count();
                $total_menit = $total_slot * 30;

                $r->jam_mulai = $start->format('H:i');
                $r->jam_selesai = $end->format('H:i');
                $r->total_menit = $total_menit;

            } else {
                $r->jam_mulai = '-';
                $r->jam_selesai = '-';
                $r->total_menit = 0;
            }
        }

        return view('dashboard.approve-reservasi', [
            'peminjaman' => $data_peminjaman,
        ]);
    }

    public function approve($id)
    {
        try {
            $peminjaman = DataPeminjaman::findOrFail($id);

            $peminjaman->update([
                'status' => 'Approve',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil diterima',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal',
            ], 500);
        }
    }

    public function reject($id)
    {
        try {
            $peminjaman = DataPeminjaman::findOrFail($id);

            $waktu = WaktuPeminjaman::where('peminjaman_id', $id)->get();

            if ($waktu->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data peminjaman tidak ada!',
                ], 409);
            }

            $peminjaman->update([
                'status' => 'Reject',
            ]);

            $waktu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil ditolak',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal',
            ], 500);
        }
    }
}
