<?php

namespace App\Livewire;

use Livewire\Component;

class MapPeminjaman extends Component
{
    public $latitude;
    public $longitude;

    protected function service()
    {
        return new \App\Services\PeminjamanService();
    }

    public function mount()
    {
        $id = request()->route('id');
        $getData = $this->service()->getDataMap($id);        

        $this->latitude = $getData->latitude;
        $this->longitude = $getData->longitude;

        $this->dispatch('init-map');
    }

    public function render()
    {
        $this->dispatch('init-map');
        return view('livewire.map-peminjaman');
    }
}
