<?php

namespace App\Livewire;

use Livewire\Component;

class SelectRuangan extends Component
{
    public $id = null ;

    public function mount($lantaiID = null)
    {   
        $this->id = $lantaiID ;
    }

    public function updatedRuangan()
    {
        info('id : ' . $this->id);
    }

    public function render()
    {
        return view('livewire.select-ruangan');
    }
}
