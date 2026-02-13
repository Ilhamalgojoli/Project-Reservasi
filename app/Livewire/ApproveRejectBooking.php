<?php

namespace App\Livewire;

use App\Models\DataPeminjaman;
use App\Models\Monitor;
use App\Models\WaktuPeminjaman;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ApproveRejectBooking extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    #[On('approve')]
    public function approve($id)
    {
        try {
            $peminjaman = DataPeminjaman::findOrFail($id);
            $peminjaman->update(['status' => 'Approve']);

            $waktu = WaktuPeminjaman::where('peminjaman_id', $peminjaman->id)
                ->orderBy('waktu_peminjaman')->get();

            $monitor = Monitor::create([
                'waktu_mulai' => $waktu->first()->waktu_peminjaman,
                'waktu_selesai' => $waktu->last()->waktu_peminjaman,
                'peminjaman_id' => $peminjaman->id,
            ]);

            $this->resetPage();
            $this->dispatch('successApprove', [
                'text' => 'Peminjaman berhasil diterima',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('Error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    #[On('reject')]
    public function reject($id, $alasan)
    {
        try {
            \Log::info('alasan'.$alasan);
            $peminjaman = DataPeminjaman::findOrFail($id);
            $peminjaman->update([
                'status' => 'Reject',
                'alasan_penolakan' => $alasan,
            ]);

            WaktuPeminjaman::where('peminjaman_id', $id)->delete();

            $this->resetPage();
            $this->dispatch('successReject', [
                'text' => 'Peminjaman berhasil ditolak',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('Error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function getData(string $page)
    {
        $pageName = $page === 'approvePage' ? 'pageApprove' : 'pageHistory';

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
        })->when($this->search && $page === 'approvePage', function ($query) {
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
        })->paginate(5, '*', $pageName);

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

    public function render()
    {
        return view('livewire.approve-reject-booking', [
            'peminjaman' => $this->getData('approvePage'),
        ]);
    }
}
