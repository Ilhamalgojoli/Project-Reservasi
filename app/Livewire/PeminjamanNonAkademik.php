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
    public $userIdentifier;

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

    protected function messages()
    {
        return [
            'fakultas.required' => 'Fakultas wajib diisi',
            'prodi.required' => 'Program studi wajib diisi',

            'jenisPeminjaman.required' => 'Jenis peminjaman wajib dipilih',

            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',

            'lantaiID.required' => 'Lantai wajib dipilih',
            'lantaiID.integer' => 'Lantai tidak valid',

            'ruanganID.required' => 'Ruangan wajib dipilih',
            'ruanganID.integer' => 'Ruangan tidak valid',

            'pilihJam.required' => 'Minimal pilih satu jam',
            'pilihJam.array' => 'Format jam tidak valid',
            'pilihJam.min' => 'Minimal pilih satu jam',

            'muatanKapasitas.required' => 'Kapasitas wajib diisi',
            'muatanKapasitas.integer' => 'Kapasitas harus angka',
            'muatanKapasitas.min' => 'Kapasitas minimal 1',

            'penanggungJawab.required' => 'Penanggung jawab wajib diisi',
            'penanggungJawab.min' => 'Minimal 3 karakter',

            'kontakPenanggungJawab.required' => 'Kontak wajib diisi',
            'kontakPenanggungJawab.numeric' => 'Kontak harus angka',

            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
        ];
    }

    public function mount($id, $jenisPeminjaman, $fakultas, $prodi)
    {
        $this->lantai = $this->service()->getLantai($id);
        $this->jamList = $this->service()->generateJam('06:30', '22:30');

        $this->jenisPeminjaman = $jenisPeminjaman;
        $this->fakultas = $fakultas;
        $this->prodi = $prodi;
        $this->userIdentifier = session('user_identifier');
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

    #[On('non-akademik')]
    public function submitForm()
    {
        try {
            $data = $this->validate();

            $peminjaman = $this->service()->create($data);
            if ($peminjaman) {
                $this->service()->createKegiatan($this->penanggungJawab, $this->ruanganID);
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
                    'maxKapasitas',
                ]);

                $this->dispatch('resetSelect');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap error validasi
            $errors = $e->validator->errors();

            // Untuk validasi di parent component dikirim melewati event dispatch
            if ($errors->has('fakultas')) {
                \Log::info('jalan fakultas error');
                $this->dispatch('fakultasError', [
                    'error' => $errors->first('fakultas'),
                    'source' => 'fakultas'
                ]);
            }

            // Untuk validasi di parent component dikirim melewati event dispatch
            if ($errors->has('prodi')) {
                \Log::info('jalan prodi error');
                $this->dispatch('prodiError', [
                    'error' => $errors->first('prodi'),
                    'source' => 'prodi'
                ]);
            }

            // Lempar pesan error validasi 
            throw $e;
        } catch (\Exception $e) {
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
