<?php

namespace App\Livewire\User;

use App\Models\Gedung;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class PilihGedung extends Component
{
    #[Url]
    public $search = '';

    #[Computed]
    public function datas()
    {
        return Gedung::select('id', 'nama_gedung', 'keterangan', 'gambar', 'kode_gedung')
            ->where('status', '=', 'Aktif')
            ->where(function($query) {
                $query->where('nama_gedung', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_gedung', 'like', '%' . $this->search . '%');
            })->get();
    }

    public function render()
    {
        return view('livewire.user.pilih-gedung', [
            'datas' => $this->datas
        ]);
    }
}
