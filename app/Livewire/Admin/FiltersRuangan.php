<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\RuanganService;

class FiltersRuangan extends Component
{
    public $lantai;
    public $dataLantai = [];
    
    public function mount(RuanganService $service)
    {
        $id = request()->route('id');
        $this->dataLantai = $service->getDataLantai($id);
    }
    
    public function filter()
    {
        $this->dispatch('filterButton', $this->lantai);
    }

    public function render()
    {
        return view('livewire.admin.filters-ruangan');
    }
}
