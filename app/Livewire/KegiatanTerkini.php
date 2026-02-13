<?php

namespace App\Livewire;

use App\Models\KegiatanTerkiniModel;
use Livewire\Component;

class KegiatanTerkini extends Component
{
    public function getKegiatanTerkini()
    {
        info('click');

        $data = KegiatanTerkiniModel::select('pesan')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
        
        return $data;
    }

    public function render()
    {
        return view('livewire.kegiatan-terkini', [
            'datas' => $this->getKegiatanTerkini(),
        ]);
    }
}
