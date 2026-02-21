<?php

namespace App\Livewire;

use App\Models\Monitor;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MonitorDashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public string $tab = 'akademik';
    protected $queryString = ['tab'];

    public function setTab(string $tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }
    
    #[On('approveData')]
    public function reRender($monitor = null)
    {
        
    }

    public function render()
    {
        return view('livewire.monitorDashboard', [
            'akademik' => $this->tab === 'akademik'
                ? $this->ambilData('akademik')
                : collect(),

            'non_akademik' => $this->tab === 'non-akademik'
                ? $this->ambilData('non-akademik')
                : collect(),
        ]);
    }

    protected function ambilData(string $jenis)
    {
        $pageName = $jenis === 'akademik'
            ? 'pageAkademik'
            : 'pageNonAkademik';

        $monitor = Monitor::with([
            'peminjaman:id,fakultas,prodi,kode_matkul,lantai,ruangan_id,tanggal_peminjaman,muatan,kontak_penanggung_jawab,penanggung_jawab',
            'peminjaman.ruangan:id,kode_ruangan,lantai_id',
            'peminjaman.ruangan.lantai:id,lantai,gedung_id',
            'peminjaman.ruangan.lantai.gedung:id,nama_gedung',
        ])->whereHas('peminjaman', function ($q) use ($jenis) {
            $q->where('jenis_peminjaman', $jenis);
        })
            ->select('waktu_mulai', 'waktu_selesai', 'peminjaman_id', 'status')
            ->where('status', 'Di jadwalkan')
            ->paginate(5, ['*'], $pageName)
            ->through(function ($item) {
                $now = Carbon::now();
                $end = Carbon::parse($item->waktu_selesai);

                $item->sisa_detik = $now->lt($end)
                    ? $now->diffInSeconds($end)
                    : 0;

                return $item;
            });

        return $monitor;
    }
}
