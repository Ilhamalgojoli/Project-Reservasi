<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DataPeminjaman;
use App\Models\WaktuPeminjaman;
use App\Models\Ruangan;
use App\Models\Monitor;
use Carbon\Carbon;

class ApproveRejectBooking extends Component
{
    public $peminjaman;

    public function mount()
    {
        $this->loadPeminjaman();
    }

    public function loadPeminjaman()
    {
        $data_peminjaman = DataPeminjaman::with('waktuPeminjaman')
            ->where('status', 'Waiting')->get();

        $ruanganMap = Ruangan::join('lantais', 'lantais.id', '=', 'ruangans.lantai_id')
            ->join('gedungs', 'gedungs.id', '=', 'lantais.gedung_id')
            ->select('ruangans.id', 'ruangans.kode_ruangan', 'gedungs.nama_gedung')
            ->get()
            ->keyBy('id');

        foreach ($data_peminjaman as $r) {
            $ruangan = $ruanganMap[$r->ruangan] ?? null;

            $r->kode_ruangan = $ruangan?->kode_ruangan ?? '-';
            $r->nama_gedung = $ruangan?->nama_gedung ?? '-';

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

        $this->peminjaman = $data_peminjaman;
    }

    public function approve($id)
    {
        try {
            $peminjaman = DataPeminjaman::findOrFail($id);
            $peminjaman->update(['status' => 'Approve']);

            $waktu = WaktuPeminjaman::where('peminjaman_id', $peminjaman->id)
                ->orderBy('waktu_peminjaman')->get();

            Monitor::create([
                'waktu_mulai' => $waktu->first()->waktu_peminjaman,
                'waktu_selesai' => $waktu->last()->waktu_peminjaman,
                'peminjaman_id' => $peminjaman->id,
            ]);

            $this->loadPeminjaman();

            $this->dispatch('Success', 'Peminjaman berhasil diterima');
        } catch (\Exception $e) {
            $this->dispatch('Error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function reject($id, $alasan)
    {
        try {
            $peminjaman = DataPeminjaman::findOrFail($id);
            $peminjaman->update([
                'status' => 'Reject',
                'alasan_penolakan' => $alasan
            ]);

            WaktuPeminjaman::where('peminjaman_id', $id)->delete();

            $this->loadPeminjaman();

            $this->dispatch('Success', 'Peminjaman berhasil ditolak');
        } catch (\Exception $e) {
            $this->dispatch('Error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.approve-reject-booking');
    }
}
