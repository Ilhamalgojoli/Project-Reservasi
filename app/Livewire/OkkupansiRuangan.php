<?php

namespace App\Livewire;

use App\Models\Gedung;
use Livewire\Component;

class OkkupansiRuangan extends Component
{
    public $okkupansi = [];

    public function getDataOkkupansi()
    {
        $data = Gedung::select('id', 'nama_gedung')
            ->withCount([
                'ruangan as totalRuanganTerpakai' => function ($q) {
                    $q->whereHas('dataPeminjaman', function ($q) {
                        $q->where('status', 'Approve');
                    });
                },
                'ruangan as totalRuanganTidakTerpakai' => function($q){
                    $q->whereDoesntHave('dataPeminjaman', function($q) {
                        $q->where('status', 'Approve');
                    });  
                },
                'ruangan as totalRuangan',
            ])
            ->get()
            ->map(function ($i) {
                $i->terpakai = $i->totalRuangan > 0
                    ? ($i->totalRuanganTerpakai / $i->totalRuangan) * 100
                    : 0;
                $i->tidakTerpakai = $i->totalRuangan > 0 
                    ? ($i->totalRuanganTidakTerpakai / $i->totalRuangan) * 100
                    : 0;

                return $i;
            });
        return $data;
    }

    public function mount()
    {
        $this->okkupansi = $this->getDataOkkupansi();
        $this->dispatch('okkupansi', $this->okkupansi);
    }

    public function render()
    {
        return view('livewire.okkupansi-ruangan');
    }
}
