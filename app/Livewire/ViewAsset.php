<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Asset;

class ViewAsset extends Component
{
    public $asset = [];
    protected $listeners =[
        'getRuanganID' => 'getAsset'
    ];

    public function getAsset($ruanganID)
    {
        info('ruangan ID Asset : ' . $ruanganID);
        $this->asset = Asset::select('nama_asset', 'jumlah_asset')
            ->where('ruangan_id', $ruanganID)
            ->get();
    }

    public function render()
    {
        return view('livewire.view-asset', [
            'assets' => $this->asset
        ]);
    }
}
