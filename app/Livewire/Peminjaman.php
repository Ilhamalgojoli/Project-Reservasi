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
    public $errorFakultas = null;
    public $errorProdi = null;

    protected $listeners = [
        'fakultasError' => 'errorHandle',
        'prodiError' => 'errorHandle',
    ];

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

    public function errorHandle($data)
    {
        if (!isset($data['source'], $data['error'])) 
            return ;
        

        switch ($data['source']) {
            case 'fakultas':
                $this->errorFakultas = $data['error'];
                break;
            case 'prodi':
                $this->errorProdi = $data['error'];
                break;
            default:
                break;
        }
    }

    public function updatedFakultas()
    {
        $this->prodies = $this->service()->getProdi($this->fakultas);
        $this->prodi = null;
        $this->errorFakultas = null;
        $this->errorProdi = null;
    }

    public function render()
    {
        return view('livewire.peminjaman');
    }
}
