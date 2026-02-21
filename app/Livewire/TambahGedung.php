<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Gedung;

class TambahGedung extends Component
{
    public $popUpTambah = false;
    public $popUpEdit = false;
    public $gedungId;

    protected $listeners = [
        "closeButtonTambah" => "closePopUpTambah",
        "closeButtonEdit" => "closePopUpEdit",
        "successCreated" => "closePopUpTambah"
    ];

    protected function service()
    {
        return new \App\Services\TambahEditGedungService;
    }

    public function openPopUpTambah()
    {   
        $this->popUpTambah = true;
        $this->dispatch('init-map-tambah');
    }

    public function openPopUpEdit($gedungID)
    {
        $this->popUpEdit = true;
        $this->dispatch('init-map-edit');
        $this->gedungId = $gedungID;
    }

    public function closePopUpTambah()
    {
        $this->popUpTambah = false;
    }

    public function closePopUpEdit()
    {
        $this->popUpEdit = false;
    }

    public function render()
    {
        $data = $this->service()->getDataGedung();

        return view('livewire.tambah-gedung', [
            'datas' => $data
        ]);
    }
}
