<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\RuanganService;

class FiltersRuangan extends Component
{
    public $lantai;
    public $dataLantai = [];
    protected $ruanganService;
    
    public function __construct()
    {
        $this->ruanganService = new RuanganService();
    }

    public function mount()
    {
        $id = request()->route('id');
        $this->dataLantai = $this->ruanganService->getDataLantai($id);
    }
    
    public function filter()
    {
        $this->dispatch('filterButton', $this->lantai);
    }

    public function render()
    {
        return view('livewire.filters-ruangan');
    }
}
