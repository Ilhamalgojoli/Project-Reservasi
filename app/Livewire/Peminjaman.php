<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Peminjaman extends Component
{
    public $routeId;
    public $jenisPeminjaman;
    public $fakultas;
    public $faculties = [];
    public $prodies = [];
    public $prodi;

    protected function service()
    {
        return new \App\Services\PeminjamanService;
    }

    public function mount()
    {
        $this->routeId = request()->route('id');
        $this->jenisPeminjaman = 'akademik';
        $this->faculties = $this->service()->getFakultas();
    }

    #[On('resetSelect')]
    public function handleReset()
    {
        $this->fakultas = null;
        $this->prodi = null;
    }

    public function updatedFakultas()
    {
        $this->prodies = $this->service()->getProdi($this->fakultas);
    }

    public function render()
    {
        return view('livewire.peminjaman');
    }
}
