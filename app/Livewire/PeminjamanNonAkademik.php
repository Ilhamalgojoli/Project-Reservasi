<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;


class PeminjamanNonAkademik extends Component
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
    public $tanggal;
    public $muatanKapasitas;
    public $deskripsi;
    public $penanggungJawab;
    public $kontakPenanggungJawab;  

    protected function service()
    {
        return new \App\Services\PeminjamanService;
    }

    protected function rules()
    {
        return [
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
        $this->dispatch('getRuanganID' , $this->ruanganID);
    }

    #[On('non-akademik')]
    public function submitForm()
    {
        $data = $this->validate();

        try{    
            $peminjaman = $this->service()->create($data);
            
            if($peminjaman){
                $this->service()->createKegiatan($this->penanggungJawab, $this->ruanganID);
                $this->dispatch('successNonAkademik');

                $this->reset();
            }
        } catch(\DomainException $e){
            $this->dispatch('errorNonAkadedmik', $e->getMessage());
        }
    }

    public function toggleDropdown()
    {
        $this->dropdownOpen = !$this->dropdownOpen;
    }

    public function render()
    {
        return view('livewire.peminjaman-non-akademik');
    }
}
