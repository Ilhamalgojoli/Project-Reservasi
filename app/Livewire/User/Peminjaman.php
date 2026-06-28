<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\PeminjamanService;

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
    public $buildingName = 'Gedung';
    public $buildingDesc = '';

    protected $listeners = [
        'fakultasError' => 'errorHandle',
        'prodiError' => 'errorHandle',
    ];

    public function mount()
    {
        $this->routeId = request()->route('id');

        $this->jenisPeminjaman = session('role_name') === 'DOSEN' || session('role_name') === 'BAA'
            ? 'akademik'
            : 'non-akademik';

        $this->faculties = app(PeminjamanService::class)->getFakultas();

        # Kalau nilai fakultas nya ada hasil dari session ambil dan simpan di properti fakultas
        if (session('faculty')) {
            $this->fakultas = (int) session('faculty');
        }

        if ($this->fakultas) {
            $this->updatedFakultas();
        }

        $building = app(PeminjamanService::class)->getBuilding((int) $this->routeId);
        if ($building) {
            $this->buildingName = $building->nama_gedung;
            $this->buildingDesc = $building->keterangan;
        }
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
            return;

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
        $this->prodies = app(PeminjamanService::class)->getProdi($this->fakultas);

        # Kalau nilai prodi nya ada hasil dari session ambil dan simpan di properti prodi
        if (session('studyProgram')) {
            $this->prodi = (int) session('studyProgram');
        }
    }

    public function render()
    {
        return view('livewire.user.peminjaman');
    }
}
