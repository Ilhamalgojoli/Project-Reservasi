<?php

namespace App\Livewire\User;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\Reactive;
use App\Services\PeminjamanService;

class PeminjamanNonAkademik extends Component
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
    public $tanggal;
    public $muatanKapasitas;
    public $deskripsi;
    public $penanggungJawab;
    public $kontakPenanggungJawab;
    public $email;
    public $userIdentifier;

    protected function rules()
    {
        return app(PeminjamanService::class)->getRules('non-akademik');
    }

    protected function messages()
    {
        return app(PeminjamanService::class)->getMessages();
    }

    public function mount($id, $jenisPeminjaman, $fakultas, $prodi)
    {
        $this->lantai = app(PeminjamanService::class)->getLantai($id);
        $this->jamList = app(PeminjamanService::class)->generateJam('06:30', '22:30');

        $this->jenisPeminjaman = $jenisPeminjaman;
        $this->penanggungJawab = (string) session('username');
        $this->userIdentifier = (string) session('user_identifier');
        $this->kontakPenanggungJawab = (string) session('phone_number');
    }

    public function updatedLantaiID($value)
    {
        $this->ruangan = app(PeminjamanService::class)->getRuangan($value);
        $this->dispatch('floorSelected', ruangan: $this->ruangan);
    }

    public function updatedRuanganID($value)
    {
        $this->maxKapasitas = app(PeminjamanService::class)->getMaxKapasitas($value);
        $this->dispatch('getRuanganID', ruanganID: $value);
    }

    # Event submit peminjaman
    public function submitForm()
    {
        try {
            $data = $this->validate();

            # cek siapa actor siapa yg melakukan submit
            if (app(PeminjamanService::class)->create($data, session('role_name'))) {
                $this->sendSuccessResponse();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->validationError($e->validator->errors());
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('errorNonAkademik', $e->getMessage());
        }
    }

    private function sendSuccessResponse()
    {
        $this->dispatch('successNonAkademik');
        $this->dispatch('floorSelected', ruangan: []);
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

    private function validationError($errors)
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

    # Untuk menampilkan rentang waktu yang dipilih user
    public function getFormattedRange()
    {
        if (empty($this->pilihJam)) {
            return '';
        }

        $jam = array_unique($this->pilihJam);
        sort($jam);

        $start = $jam[0];
        $end = count($jam) > 1 ? end($jam) : Carbon::parse($start)->addMinutes(30)->format('H:i');

        return $start . ' - ' . $end;
    }

    public function render()
    {
        return view('livewire.user.peminjaman-non-akademik');
    }
}
