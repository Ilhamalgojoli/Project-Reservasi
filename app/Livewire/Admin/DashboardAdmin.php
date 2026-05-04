<?php

namespace App\Livewire\Admin;

use App\Models\Ruangan;
use App\Services\DashboardService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DashboardAdmin extends Component
{
    public $periode_semester = '';

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public function mount(DashboardService $dashboard)
    {
        if (session('role_name') !== 'BAA') {
            abort(403);
        }

        # Update status sekali di awal
        $dashboard->updateStatusFinish();
    }

    public function applyFilter()
    {
        # Method ini hanya untuk memicu Livewire agar merefresh komponen 
        # dan memanggil ulang method stats() dengan nilai periode_semester yang baru
    }

    #[Computed]
    public function stats()
    {
        $dashboard = app(DashboardService::class);
        $approve = $dashboard->getRuanganTerpakai($this->periode_semester);

        return [
            'waiting' => $dashboard->getRuanganWaiting($this->periode_semester),
            'approve' => $approve,
            'tersedia' => $dashboard->getRuanganTersedia($approve),
            'gedung' => $dashboard->chartGedung($this->periode_semester),
            'dataAktif' => $this->getAktifTidakAktif(),
            'peminjamanPerFakultas' => $dashboard->getDataPeminjamanPerFakultas($this->periode_semester),
            'okkupansi' => $dashboard->getDataOkkupansi($this->periode_semester),
            'kegiatanTerkini' => $dashboard->getDataKegiatanTerkini(),
            'periodeOptions' => $dashboard->getPeriodeOptions(),
        ];
    }

    protected function getAktifTidakAktif(): array
    {
        return [
            'ruanganAktif' => Ruangan::where('status', 'Aktif')->count(),
            'ruanganTidakAktif' => Ruangan::where('status', 'Tidak Aktif')->count()
        ];
    }

    public function refreshKegiatanTerkini(): void
    {
        $this->dispatch('refresh');
    }

    public function render()
    {
        $s = $this->stats;

        return view('livewire.admin.dashboard-admin', [
            'waiting' => $s['waiting'],
            'approve' => $s['approve'],
            'tersedia' => $s['tersedia'],
            'gedung' => $s['gedung'],
            'dataAktif' => $s['dataAktif'],
            'peminjamanPerFakultas' => $s['peminjamanPerFakultas'],
            'okkupansi' => $s['okkupansi'],
            'kegiatanTerkini' => $s['kegiatanTerkini'],
            'periodeOptions' => $s['periodeOptions'],
        ]);
    }
}
