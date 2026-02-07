<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ruangan;
use App\Models\Lantai;

class Peminjaman extends Component
{
    public $lantai = [];
    public $lantaiID ;

    public function mount($id)
    {   
        info('id : '. $id);
        $this->lantai = Lantai::select('id', 'lantai')
            ->where('gedung_id', $id)
            ->get();
        $this->lantaiID = null;
    }

    public function updatedLantaiID()
    {
        info('lantai id : ' . $this->lantaiID);
    }

    public function render()
    {
        return view('livewire.peminjaman');
    }
}
