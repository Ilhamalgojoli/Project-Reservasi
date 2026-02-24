<?php

namespace App\Livewire;

use App\Services\DashboardService;
use Livewire\Component;

class Home extends Component
{
    public $waiting;
    public $approve;
    public $tersedia;
    public $gedung = [];

    public function render(DashboardService $dashboard)
    {
        $this->waiting = $dashboard->getRuanganWaiting();
        $this->approve = $dashboard->getRuanganTerpakai();
        $this->tersedia = $dashboard->getRuanganTersedia($this->approve);
        $this->gedung = $dashboard->chartGedung();

        $this->dispatch('dataGedung', $this->gedung);

        return view('livewire.home');
    }
}
