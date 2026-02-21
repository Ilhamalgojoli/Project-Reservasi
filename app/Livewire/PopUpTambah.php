<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class PopUpTambah extends Component
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

    protected function service()
    {
        return new \App\Services\TambahEditGedungService;
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
        } catch (\DomainException $e) {
            $this->dispatch('errorCreated');
        }
    }

    public function render()
    {
        return view('livewire.pop-up-tambah');
    }
}
