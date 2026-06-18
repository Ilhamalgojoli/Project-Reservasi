<?php

namespace App\Livewire\User;

use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use App\Services\PeminjamanService;

class PeminjamanAkademik extends Component
{
    public $lantai = [];

    public $ruangan = [];

    public $lantaiID = null;

    public $ruanganID = null;

    public $maxKapasitas;

    public $jenisPeminjaman;

    #[Reactive]
    public $fakultas;

    #[Reactive]
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

    public $email;

    public $userIdentifier;

    protected function rules()
    {
        return $this->service()->getRules('akademik');
    }

    protected function messages()
    {
        return $this->service()->getMessages();
    }

    protected function service()
    {
        return app(PeminjamanService::class);
    }

    public function mount($id, $jenisPeminjaman, $fakultas, $prodi)
    {
        $this->lantai = $this->service()->getLantai($id);
        $this->jamList = $this->service()->generateJam('06:30', '22:30');

        $this->jenisPeminjaman = $jenisPeminjaman;
        $this->fakultas = $fakultas;
        $this->prodi = $prodi;
        $this->penanggungJawab = (string) session('username');
        $this->userIdentifier = (string) session('user_identifier');
    }

    public function updatedProdi($value)
    {
        // No longer needed but kept for potential other logic
    }

    public function updatedLantaiID($value)
    {
        $this->ruangan = $this->service()->getRuangan($value);
    }

    public function updatedRuanganID($value)
    {
        $this->maxKapasitas = $this->service()->getMaxKapasitas($value);
        $this->dispatch('getRuanganID', ruanganID: $value);
    }

    public function toggleDropdown()
    {
        $this->dropdownOpen = !$this->dropdownOpen;
    }

    #[On('akademik')]
    public function submitForm()
    {
        try {
            $data = $this->validate();

            if ($this->service()->create($data, session('role_name'))) {
                $this->sendSuccessResponse();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e->validator->errors());
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('errorAkademik', $e->getMessage());
        }
    }

    private function sendSuccessResponse()
    {
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
            'email',
            'maxKapasitas'
        ]);
        $this->dispatch('resetSelect');
    }

    private function dispatchValidationErrors($errors)
    {
        if ($errors->has('fakultas')) {
            $this->dispatch('fakultasError', ['error' => $errors->first('fakultas'), 'source' => 'fakultas']);
        }
        if ($errors->has('prodi')) {
            $this->dispatch('prodiError', ['error' => $errors->first('prodi'), 'source' => 'prodi']);
        }
    }

    public function setFakultasProdi($jenisPeminjaman, $fakultas, $prodi)
    {
        $this->jenisPeminjaman = $jenisPeminjaman;
        $this->fakultas = $fakultas;
        $this->prodi = $prodi;
    }

    public function updatedPilihJam($value)
    {
        if (count($this->pilihJam) > 2) {
            $latest = end($this->pilihJam);
            $this->pilihJam = [$latest];
        }
    }

    public function getFormattedRange()
    {
        if (empty($this->pilihJam)) {
            return '';
        }

        $jam = array_unique($this->pilihJam);
        sort($jam);

        $start = $jam[0];
        $end = count($jam) > 1 ? end($jam) : \Carbon\Carbon::parse($start)->addMinutes(30)->format('H:i');

        return $start . ' - ' . $end;
    }

    public function render()
    {
        $mataKuliahList = $this->service()->getMataKuliah($this->prodi);
        return view('livewire.user.peminjaman-akademik', compact('mataKuliahList'));
    }
}
