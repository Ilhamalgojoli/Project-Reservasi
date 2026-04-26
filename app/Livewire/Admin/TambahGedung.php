<?php

namespace App\Livewire\Admin;

use App\Services\GedungService;
use Livewire\Component;

class TambahGedung extends Component
{
    public $popUpTambah = false;
    public $popUpEdit = false;
    public $gedungId;

    protected $listeners = [
        "closeButtonTambah" => "closePopUpTambah",
        "closeButtonEdit" => "closePopUpEdit",
        "successClosePopUp" => "closePopUpTambah",
        "closeAfterConfirm" => "closePopUpEdit"
    ];

    public function mount()
    {
        if (session('role_name') !== 'BAA') {
            abort(403);
        }
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

    public function render(GedungService $service)
    {
        $data = $service->getDataGedung('kelolaGedung');

        return view('livewire.admin.tambah-gedung', [
            'datas' => $data
        ]);
    }
}
