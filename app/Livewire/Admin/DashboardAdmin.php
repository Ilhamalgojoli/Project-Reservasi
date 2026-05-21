<?php

namespace App\Livewire\Admin;

use App\Models\Ruangan;
use App\Models\Gedung;
use App\Services\DashboardService;
use App\Services\NotificationService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DashboardAdmin extends Component
{
    public $periode_semester = '';
    public $aktif_gedung_id = '';

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

        # Set default periode ke yang sekarang
        $data = $dashboard->getPeriodeOptions();
        $this->periode_semester = $data['current'] ?? '';
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
            'kegiatanTerkini'    => app(NotificationService::class)->getDataKegiatanTerkini(3),
            'kegiatanTerkiniAll' => app(NotificationService::class)->getDataKegiatanTerkiniAll(),
            'periodeOptions' => $dashboard->getPeriodeOptions()['options'],
            'listGedung' => Gedung::all(),
        ];
    }

    protected function getAktifTidakAktif(): array
    {
        $queryAktif = Ruangan::where('status', 'Aktif');
        $queryTidakAktif = Ruangan::where('status', 'Tidak Aktif');

        if ($this->aktif_gedung_id) {
            $queryAktif->whereHas('lantai', function ($q) {
                $q->where('gedung_id', $this->aktif_gedung_id);
            });
            $queryTidakAktif->whereHas('lantai', function ($q) {
                $q->where('gedung_id', $this->aktif_gedung_id);
            });
        }

        return [
            'ruanganAktif' => $queryAktif->count(),
            'ruanganTidakAktif' => $queryTidakAktif->count()
        ];
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
            'kegiatanTerkini'    => $s['kegiatanTerkini'],
            'kegiatanTerkiniAll' => $s['kegiatanTerkiniAll'],
            'periodeOptions' => $s['periodeOptions'],
            'listGedung' => $s['listGedung'],
        ]);
    }
}
