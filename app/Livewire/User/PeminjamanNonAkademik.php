<?php

namespace App\Livewire\User;

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
    public $email;
    public $userIdentifier;

    protected function service()
    {
        return new \App\Services\PeminjamanService;
    }

    protected function rules()
    {
        return $this->service()->getRules('non-akademik');
    }

    protected function messages()
    {
        return $this->service()->getMessages();
    }

    public function mount($id, $jenisPeminjaman, $fakultas, $prodi)
    {
        $this->lantai = $this->service()->getLantai($id);
        $this->jamList = $this->service()->generateJam('06:30', '22:30');

        $this->jenisPeminjaman = $jenisPeminjaman;
        $this->fakultas = $fakultas;
        $this->prodi = $prodi;
        $this->userIdentifier = (string) session('user_identifier');
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

    public function submitForm()
    {
        try {
            $data = $this->validate();

            if ($this->service()->create($data, session('role_name'))) {
                $this->service()->createKegiatan($this->penanggungJawab, $this->ruanganID);
                $this->sendSuccessResponse();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatchValidationErrors($e->validator->errors());
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('errorNonAkademik', $e->getMessage());
        }
    }

    private function sendSuccessResponse()
    {
        $this->dispatch('successNonAkademik');
        $this->reset([
            'lantaiID',
            'ruanganID',
            'pilihJam',
            'muatanKapasitas',
            'tanggal',
            'deskripsi',
            'penanggungJawab',
            'kontakPenanggungJawab',
            'email',
            'maxKapasitas'
        ]);
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

    public function toggleDropdown()
    {
        $this->dropdownOpen = !$this->dropdownOpen;
    }

    public function render()
    {
        return view('livewire.user.peminjaman-non-akademik');
    }
}
