<?php

namespace App\Http\Controllers;

use App\Models\DataPeminjaman;
use App\Models\Monitor;
use App\Models\Ruangan;
use App\Models\WaktuPeminjaman;
use Carbon\Carbon;

class ApproveController extends Controller
{
    public function index()
    {
        // $data_peminjaman = DataPeminjaman::with('waktuPeminjaman')->where('status', '=', 'Waiting')->get();
        // $ruanganMap = Ruangan::join('lantais', 'lantais.id', '=', 'ruangans.lantai_id')
        //     ->join('gedungs', 'gedungs.id', '=', 'lantais.gedung_id')
        //     ->select(
        //         'ruangans.id',
        //         'ruangans.kode_ruangan',
        //         'gedungs.nama_gedung'
        //     )
        //     ->get()
        //     ->keyBy('id');

        // foreach ($data_peminjaman as $r) {
        //     $ruangan = $ruanganMap[$r->ruangan];

        //     $r->kode_ruangan = $ruangan?->kode_ruangan ?? '-';
        //     $r->nama_gedung = $ruangan?->nama_gedung ?? '-';

        //     if ($r->waktuPeminjaman->isNotEmpty()) {
        //         $waktu = $r->waktuPeminjaman
        //             ->sortBy('waktu_peminjaman')
        //             ->values();

        //         $start = Carbon::parse($waktu->first()->waktu_peminjaman);
        //         $end = Carbon::parse($waktu->last()->waktu_peminjaman);

        //         $total_slot = $waktu->count();
        //         $total_menit = $total_slot * 30 - 30;

        //         $r->jam_mulai = $start->format('H:i');
        //         $r->jam_selesai = $end->format('H:i');
        //         $r->total_menit = $total_menit;

        //     } else {
        //         $r->jam_mulai = '-';
        //         $r->jam_selesai = '-';
        //         $r->total_menit = 0;
        //     }
        // }

        return view('dashboard.approve-reservasi');
    }

    // public function approve($id)
    // {
    //     try {
    //         $peminjaman = DataPeminjaman::findOrFail($id);

    //         $peminjaman->update([
    //             'status' => 'Approve',
    //         ]);

    //         $waktu = WaktuPeminjaman::where('peminjaman_id', $peminjaman->id)
    //             ->get()
    //             ->sortBy('waktu_peminjaman')
    //             ->values();

    //         $start = Carbon::parse($waktu->first()->waktu_peminjaman);
    //         $end = Carbon::parse($waktu->last()->waktu_peminjaman);

    //         Monitor::create([
    //             'waktu_mulai' => $start,
    //             'waktu_selesai' => $end,
    //             'peminjaman_id' => $peminjaman->id,
    //         ]);

    //         $this->dispatchBrowserEvent('success', [
    //             'message' => 'Peminjaman berhasil diterima',
    //         ]);
    //     } catch (\Exception $e) {
    //         $this->dispatchBrowserEvent('error', [
    //             'message' => 'Terjadi kesalahan internal: '.$e->getMessage(),
    //         ]);
    //     }
    // }

    // public function reject($id, $alasan)
    // {
    //     try {
    //         $peminjaman = DataPeminjaman::findOrFail($id);

    //         $waktu = WaktuPeminjaman::where('peminjaman_id', $id);

    //         $peminjaman->update([
    //             'status' => 'Reject',
    //             'alasan_penolakan' => $alasan,
    //         ]);

    //         $waktu->delete();

    //         $this->dispatchBrowserEvent('success', [
    //             'message' => 'Peminjaman berhasil ditolak',
    //         ]);

    //         $this->loadPeminjaman(); // refresh data
    //     } catch (\Exception $e) {
    //         $this->dispatchBrowserEvent('error', [
    //             'message' => 'Terjadi kesalahan internal: '.$e->getMessage(),
    //         ]);
    //     }
    // }
}
