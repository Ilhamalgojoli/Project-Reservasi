<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Services\GedungService;

class PopUpEditGedung extends Component
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
            'kode' => [
                'required',
                'string',
                'max:16',
                Rule::unique('gedungs', 'kode_gedung')->ignore($this->id),
            ],
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
            'nama.required' => 'Nama wajib diisi.',
            'kode.required' => 'Kode Gedung wajib diisi.',
            'jumlahLantai.required' => 'Jumlah Lantai wajib diisi.',
            'status.required' => 'Status Operasional wajib diisi.',
            'keterangan.required' => 'Deskripsi singkat wajib diisi.',
            'latitude.required' => 'Silakan pilih lokasi pada map.',
            'longitude.required' => 'Silakan pilih lokasi pada map.'
        ];
    }

    protected $listeners = [
        'deleteGedung' => 'deleteGedung'
    ];

    protected function service()
    {
        return app(GedungService::class);
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
        $this->latitude = $data->latitude;
        $this->longitude = $data->longitude;
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
        } catch(\Exception $e){
            $this->dispatch('errorUpdate', 'Gagal mengubah data gedung. Pastikan data yang dimasukkan valid.');
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
        return view('livewire.admin.pop-up-edit-gedung');
    }
}
