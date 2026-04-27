<?php

namespace App\Livewire\Admin;

use App\Services\DashboardService;
use Livewire\Component;

class OkkupansiRuangan extends Component
{
    protected $okkupansi = [];

    public function mount(DashboardService $dashboard)
    {
        if (session('role_name') !== 'BAA') {
            $this->okkupansi = null ;
            abort(403);
        }

        $this->okkupansi = $dashboard->getDataOkkupansi();
    }

    public function render()
    {
        return view('livewire.admin.okkupansi-ruangan', [
            'okkupansi' => $this->okkupansi,
        ]);
    }
}
