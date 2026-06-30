<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\GedungService;

class PopUpTambahGedung extends Component
{
    use WithFileUploads;

    public $nama;
    public $kode;
    public $jumlahLantai;
    public $status;
    public $keterangan;
    public $gambar;
    public $latitude;
    public $longitude;

    protected function rules()
    {
        return [
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:10240',
            'nama' => 'required|string|min:3|max:100',
            'kode' => 'required|string|max:16|unique:gedungs,kode_gedung',
            'jumlahLantai' => 'required|integer|min:1',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
            'keterangan' => 'required|string|max:500',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'gambar.max' => 'Gambar maksimal 10MB.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kode.required' => 'Kode Gedung wajib diisi.',
            'kode.max' => 'Kode Gedung maksimal 16 karakter.',
            'kode.unique' => 'Kode Gedung sudah terdaftar.',
            'jumlahLantai.required' => 'Jumlah Lantai wajib diisi.',
            'jumlahLantai.integer' => 'Jumlah Lantai harus berupa angka.',
            'jumlahLantai.min' => 'Jumlah Lantai minimal 1.',
            'status.required' => 'Status Operasional wajib diisi.',
            'keterangan.required' => 'Deskripsi singkat wajib diisi.',
            'keterangan.max' => 'Deskripsi singkat maksimal 500 karakter.',
            'latitude.required' => 'Silakan pilih lokasi pada map.',
            'longitude.required' => 'Silakan pilih lokasi pada map.'
        ];
    }

    protected function service()
    {
        return app(GedungService::class);
    }

    public function closeButton()
    {
        $this->dispatch('closeButtonTambah');
    }

    public function submit()
    {
        $data = $this->validate();

        try {
            $tambahGedung = $this->service()->createData($data);

            if ($tambahGedung) {
                $this->dispatch('successCreated');
            }
        } catch (\Exception $e) {
            $this->dispatch('errorCreated', [
                'text' => 'Error saat menyimpan data, coba lagi nanti.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.pop-up-tambah-gedung');
    }
}
