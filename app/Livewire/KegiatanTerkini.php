<?php

namespace App\Livewire;

use App\Services\DashboardService;
use Livewire\Component;

class KegiatanTerkini extends Component
{
    protected $listeners = [
        'refresh' => 'render'
    ];

    public function refreshKegiatanTerkini()
    {
        $this->dispatch('refresh');
    }

    public function render(DashboardService $service)
    {
        return view('livewire.kegiatan-terkini', [
            'datas' => $service->getDataKegiatanTerkini(),
        ]);
    }
}
