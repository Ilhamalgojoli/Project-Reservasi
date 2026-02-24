<?php

namespace App\Livewire;

use App\Services\DashboardService;
use Livewire\Component;

class OkkupansiRuangan extends Component
{
    public $okkupansi = [];

    public function render(DashboardService $dashboard)
    {
        $this->okkupansi = $dashboard->getDataOkkupansi();
        $this->dispatch('okkupansi', $this->okkupansi);

        return view('livewire.okkupansi-ruangan');
    }
}
