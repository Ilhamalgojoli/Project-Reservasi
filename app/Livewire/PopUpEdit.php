<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class PopUpEdit extends Component
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
    public $id;

    protected function rules()
    {
        return [
            'id' => 'required|integer',
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

    protected $listeners = [
        'deleteGedung' => 'deleteGedung'
    ];

    protected function service()
    {
        return new \App\Services\TambahEditGedungService;
    }

    public function mount($id)
    {
        $data = $this->service()->getEdit($id);

        $this->id = $id;
        $this->nama = $data->nama_gedung;
        $this->kode = $data->kode_gedung;
        $this->jumlahLantai = $data->lantai_count;
        $this->status = $data->status;
        $this->keterangan = $data->keterangan;
    }

    public function submit() 
    {
        $data = $this->validate();
        
        try{
            $edit = $this->service()->update($data);

            if($edit){
                $this->dispatch('successUpdated');
                $this->dispatch('closePopUpEdit');
            }
        } catch(\DomainException $e){

        }
    }

    public function closeButton()
    {
        $this->dispatch('closeButtonEdit');
    }

    public function deleteGedung($id)
    {
        $data = $this->service()->deleteGedung($id);
        
        if($data){
            $this->dispatch('successDeleteGedung');
        } else {
            $this->dispatch('failDelete');
        }
    }

    public function render()
    {
        return view('livewire.pop-up-edit');
    }
}
