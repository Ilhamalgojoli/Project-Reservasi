<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Services\PeminjamanService;

class KapasitasRuanganSidebar extends Component
{
    public $ruangan = [];
    public $buildingName = '';

    public function mount($id = null)
    {
        $id = $id ?? request()->route('id');
        if ($id) {
            $this->ruangan = app(PeminjamanService::class)->getRuanganByGedung((int) $id);
            $building = app(PeminjamanService::class)->getBuilding((int) $id);
            if ($building) {
                $this->buildingName = $building->nama_gedung;
            }
        }
    }

    public function render()
    {
        return view('livewire.user.kapasitas-ruangan-sidebar');
    }
}
