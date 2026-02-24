<?php

namespace App\Livewire;

use App\Services\DashboardService;
use Livewire\Component;

class KegiatanTerkini extends Component
{
    public function render(DashboardService $dashboard)
    {
        return view('livewire.kegiatan-terkini', [
            'datas' => $dashboard->getDataKegiatanTerkini(),
        ]);
    }
}
