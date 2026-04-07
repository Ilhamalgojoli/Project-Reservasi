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
    public $userIdentifier;

    protected function rules()
    {
        return [
            'fakultas' => 'required|string',
            'prodi' => 'required|string',

            'kodeMatkul' => 'required|string',
            'tanggal' => 'required|date',

            'userIdentifier' => 'required|string',

            'lantaiID' => 'required|integer',
            'ruanganID' => 'required|integer',

            'pilihJam' => 'required|array|min:1',
            'muatanKapasitas' => 'required|integer|min:1',

            'jenisPeminjaman' => 'required|string',

            'penanggungJawab' => 'required|string|min:3',
            'kontakPenanggungJawab' => 'required|numeric|digits_between:10,15',

            'deskripsi' => 'nullable|string|max:500',
        ];
    }

    protected function messages()
    {
        return [
            'fakultas.required' => 'Fakultas wajib diisi',
            'prodi.required' => 'Program studi wajib diisi',

            'kodeMatkul.required' => 'Kode mata kuliah wajib dipilih',
            'kodeMatkul.string' => 'Kode mata kuliah tidak valid',

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

            'jenisPeminjaman.required' => 'Jenis peminjaman wajib dipilih',

            'penanggungJawab.required' => 'Penanggung jawab wajib diisi',
            'penanggungJawab.min' => 'Minimal 3 karakter',

            'kontakPenanggungJawab.required' => 'Kontak wajib diisi',
            'kontakPenanggungJawab.numeric' => 'Kontak harus angka',
            'kontakPenanggungJawab.digits_between' => 'Kontak harus 10-15 digit',

            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
        ];
    }

    // Call service
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

    public function toggleDropdown()
    {
        $this->dropdownOpen = !$this->dropdownOpen;
    }

    #[On('akademik')]
    public function submitForm()
    {
        try {
            $data = $this->validate();

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
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();

            if ($errors->has('fakultas')) {
                \Log::info('jalan fakultas error');
                $this->dispatch('fakultasError', [
                    'error' => $errors->first('fakultas'),
                    'source' => 'fakultas'
                ]);
            }

            if ($errors->has('prodi')) {
                \Log::info('jalan prodi error');
                $this->dispatch('prodiError', [
                    'error' => $errors->first('prodi'),
                    'source' => 'prodi'
                ]);
            }

            throw $e;
        } catch (\Exception $e) {
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
