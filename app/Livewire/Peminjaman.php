<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Peminjaman extends Component
{
    public $routeId;
    public $jenisPeminjaman;
    public $fakultas;
    public $prodi;

    public function mount($id)
    {
        $this->routeId = request()->route('id');
        $this->jenisPeminjaman = 'akademik';
    }

    #[On('resetSelect')]
    public function handleReset()
    {
        $this->fakultas = null;
        $this->prodi = null;
    }

    public function render()
    {
        return view('livewire.peminjaman');
    }
}
