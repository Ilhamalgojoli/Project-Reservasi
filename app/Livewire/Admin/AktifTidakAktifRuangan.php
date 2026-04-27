<?php

namespace App\Livewire\Admin;

use App\Models\Ruangan;
use Livewire\Component;

class AktifTidakAktifRuangan extends Component
{
    protected $data = [];

    public function getAktifTidakAktif()
    {
        $aktif = Ruangan::where('status', 'Aktif')
            ->count();
        $tidakAktif = Ruangan::where('status', 'Tidak Aktif')
            ->count();
        
        return [
            'ruanganAktif' => $aktif, 
            'ruanganTidakAktif' => $tidakAktif
        ];
    }

    public function mount()
    {
        $this->data = $this->getAktifTidakAktif();
    }

    public function render()
    {
        return view('livewire.admin.aktif-tidak-aktif-ruangan', [
            'data' => $this->data
        ]);
    }
}
