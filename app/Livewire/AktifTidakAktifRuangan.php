<?php

namespace App\Livewire;

use App\Models\Ruangan;
use Livewire\Component;

class AktifTidakAktifRuangan extends Component
{
    public $data = [];

    public function getAktifTidakAktif()
    {
        $aktif = Ruangan::where('status', 'Aktif')
            ->count();
        $tidakAktif = Ruangan::where('status', 'Tidak Aktif')
            ->count();
        
        return [
            'ruanganAktif' => $aktif, 
            'ruanganTidakAktif' => $tidakAktif];
    }

    public function render()
    {
        $this->data = $this->getAktifTidakAktif();
        $this->dispatch('totalRuangan', $this->data);

        return view('livewire.aktif-tidak-aktif-ruangan');
    }
}
