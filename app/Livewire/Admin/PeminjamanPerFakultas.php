<?php

namespace App\Livewire\Admin;

use App\Services\DashboardService;
use Livewire\Component;

class PeminjamanPerFakultas extends Component
{
    protected $peminjamanPerFakultas = [];

    public function mount(DashboardService $dashboard)
    {
        if (session('role_name') !== 'BAA') {
            $this->peminjamanPerFakultas = null;
        }

        $this->peminjamanPerFakultas = $dashboard->getDataPeminjamanPerFakultas();
    }

    public function render()
    {
        return view('livewire.admin.peminjaman-per-fakultas', [
            'peminjamanPerFakultas' => $this->peminjamanPerFakultas,
        ]);
    }
}
