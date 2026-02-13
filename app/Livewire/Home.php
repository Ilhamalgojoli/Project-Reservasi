<?php

namespace App\Livewire;

use App\Models\DataPeminjaman;
use App\Models\Gedung;
use App\Models\Ruangan;
use Livewire\Component;

class Home extends Component
{
    public $waiting;
    public $approve;
    public $tersedia;
    public $gedung = [];

    public function getRuanganWaiting()
    {
        return $data = DataPeminjaman::where('status', 'Waiting')->count();
    }

    public function getRuanganTerpakai()
    {
        return $data = Ruangan::whereHas('dataPeminjaman', function ($q) {
            $q->where('status', 'Approve');
        })->count();
    }

    public function getRuanganTersedia()
    {
        $totalRuangan = Ruangan::count();
        $data = $totalRuangan - $this->approve;

        return $data;
    }

    public function chartGedung()
    {
        $data = Gedung::select('nama_gedung')
            ->withCount([
                'ruangan as totalWaiting' => function ($q) {
                    $q->whereHas('dataPeminjaman', function ($q) {
                        $q->where('status', 'Waiting');
                    });
                },

                'ruangan as totalTerpakai' => function ($q) {
                    $q->whereHas('dataPeminjaman', function ($q) {
                        $q->where('status', 'Approve');
                    });
                },
                'ruangan as totalRuangan',
            ])
            ->get()
            ->map(function ($i) {
                $i->totalTersedia = $i->totalRuangan - $i->totalTerpakai;

                return $i;
            });

        return $data;
    }

    public function render()
    {
        $this->waiting = $this->getRuanganWaiting();
        $this->approve = $this->getRuanganTerpakai();
        $this->tersedia = $this->getRuanganTersedia();
        $this->gedung = $this->chartGedung();

        $this->dispatch('dataGedung', $this->gedung);

        return view('livewire.home');
    }
}
