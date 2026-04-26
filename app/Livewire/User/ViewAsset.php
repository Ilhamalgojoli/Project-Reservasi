<?php

namespace App\Livewire\User;

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
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.user.view-asset', [
            'assets' => $this->asset
        ]);
    }
}
