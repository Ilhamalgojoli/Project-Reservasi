<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class PeminjamanAkademik extends Component
{
    public $lantai = [];

    public $ruangan = [];

    public $lantaiID = null;

    public $ruanganID = null;

    public $maxKapasitas;

    public $jenisPeminjaman;

    public $fakultas;

    public $prodi;

    public $dropdownOpen = false;

    public $jamList = [];

    public array $pilihJam = [];

    public $kodeMatkul;

    public $tanggal;

    public $muatanKapasitas;

    public $deskripsi;

    public $penanggungJawab;

    public $kontakPenanggungJawab;

    protected function rules()
    {
        return [
            'kodeMatkul' => 'required|string',
            'tanggal' => 'required|date',

            'lantaiID' => 'required|integer',
            'ruanganID' => 'required|integer',

            'pilihJam' => 'required|array|min:1',
            'muatanKapasitas' => 'required|integer|min:1',

            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'jenisPeminjaman' => 'required|string',

            'penanggungJawab' => 'required|string|min:3',
            'kontakPenanggungJawab' => 'required|numeric',

            'deskripsi' => 'nullable|string|max:500',
        ];
    }

    protected function service()
    {
        return new \App\Services\PeminjamanService;
    }

    public function mount($id, $jenisPeminjaman, $fakultas, $prodi)
    {
        $this->lantai = $this->service()->getLantai($id);
        $this->jamList = $this->service()->generateJam('06:30', '22:30');

        $this->jenisPeminjaman = $jenisPeminjaman;
        $this->fakultas = $fakultas;
        $this->prodi = $prodi;
    }

    public function updatedLantaiID($value)
    {
        $this->ruangan = $this->service()->getRuangan($value);
    }

    public function updatedRuanganID($value)
    {
        $this->maxKapasitas = $this->service()->getMaxKapasitas($value);
        $this->dispatch('getRuanganID', $this->ruanganID);
    }

    public function toggleDropdown()
    {
        $this->dropdownOpen = ! $this->dropdownOpen;
    }

    #[On('akademik')]
    public function submitForm()
    {
        $data = $this->validate();

        try {
            $peminjaman = $this->service()->create($data);

            if ($peminjaman) {
                $this->service()->createKegiatan($this->penanggungJawab, $this->ruanganID);
                $this->dispatch('successAkademik');

                $this->reset([
                    'lantaiID',
                    'ruanganID',
                    'pilihJam',
                    'muatanKapasitas',
                    'kodeMatkul',
                    'tanggal',
                    'deskripsi',
                    'penanggungJawab',
                    'kontakPenanggungJawab',
                    'maxKapasitas',
                    'fakultas',
                    'prodi'
                ]);
                $this->dispatch('resetSelect');
            }
        } catch (\DomainException $e) {
            $this->dispatch('errorAkademik', $e->getMessage());
        }
    }

    public function setFakultasProdi($jenisPeminjaman, $fakultas, $prodi)
    {
        $this->jenisPeminjaman = $jenisPeminjaman;
        $this->fakultas = $fakultas;
        $this->prodi = $prodi;
    }

    public function render()
    {
        return view('livewire.peminjaman-akademik');
    }
}
