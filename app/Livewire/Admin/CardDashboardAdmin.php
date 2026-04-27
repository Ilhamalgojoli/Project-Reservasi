<?php

namespace App\Livewire\Admin;

use App\Services\DashboardService;
use Livewire\Component;

class CardDashboardAdmin extends Component
{
    protected $waiting;
    protected $approve;
    protected $tersedia;
    protected $gedung = [];
    
    public function mount(DashboardService $dashboard)
    {
        $this->waiting = $dashboard->getRuanganWaiting();
        $this->approve = $dashboard->getRuanganTerpakai();
        $this->tersedia = $dashboard->getRuanganTersedia($this->approve);
        $this->gedung = $dashboard->chartGedung();
    }

    public function render()
    {
        return view('livewire.admin.card-dashboard-admin', [
            'waiting' => $this->waiting,
            'approve' => $this->approve,
            'tersedia' => $this->tersedia,
            'gedung' => $this->gedung,
        ]);
    }
}
