<?php

namespace App\Livewire\Admin;

use App\Services\GedungService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class KelolaGedung extends Component
{
    public $popUpTambah = false;
    public $popUpEdit = false;
    public $gedungId;

    #[Url]
    public $search = '';

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

    #[Computed]
    public function datas()
    {
        $service = app(GedungService::class);
        return $service->getDataGedung($this->search);
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
        return view('livewire.admin.kelola-gedung', [
            'datas' => $this->datas
        ]);
    }
}
