<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class PopupDetailKegiatan extends Component
{
    public $data;

    public function closePopUp()
    {
        $this->dispatch('closeKegiatan');
    }

    public function mount(array $data)
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.admin.popup-detail-kegiatan');
    }
}
