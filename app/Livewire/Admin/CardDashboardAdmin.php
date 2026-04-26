<?php

namespace App\Livewire\Admin;

use App\Services\DashboardService;
use Livewire\Component;

class CardDashboardAdmin extends Component
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

        return view('livewire.admin.card-dashboard-admin',);
    }
}
