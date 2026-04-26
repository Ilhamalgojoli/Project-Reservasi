<?php

namespace App\Livewire\Admin;

use App\Services\DashboardService;
use Livewire\Component;

class PeminjamanPerFakultas extends Component
{
    public $peminjamanPerFakultas = [];

    public function render(DashboardService $dashboard)
    {
        $this->peminjamanPerFakultas = $dashboard->getDataPeminjamanPerFakultas();
        $this->dispatch('peminjamanPerFakultas', $this->peminjamanPerFakultas);

        return view('livewire.admin.peminjaman-per-fakultas');
    }
}
