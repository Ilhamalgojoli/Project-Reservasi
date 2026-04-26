<?php

namespace App\Livewire\User;

use Livewire\Component;

class MapPeminjaman extends Component
{
    public $latitude;
    public $longitude;

    protected function service()
    {
        return new \App\Services\PeminjamanService();
    }

    public function mount($id = null)
    {
        $id = $id ?? request()->route('id');
        $getData = $this->service()->getDataMap((int) $id);  

        if ($getData) {
            $this->latitude = $getData->latitude;
            $this->longitude = $getData->longitude;
        }
    }

    public function render()
    {
        $this->dispatch('init-map', 
            lat: $this->latitude, 
            lng: $this->longitude
        );
        return view('livewire.user.map-peminjaman');
    }
}
