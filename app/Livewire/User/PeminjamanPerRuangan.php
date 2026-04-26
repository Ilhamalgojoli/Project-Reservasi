<?php

namespace App\Livewire\User;

use App\Services\PeminjamanService;
use Livewire\Component;
use Livewire\Attributes\On;

class PeminjamanPerRuangan extends Component
{
    public $ruanganID;

    #[On('getRuanganID')]
    public function updateRuangan($ruanganID)
    {
        $this->ruanganID = $ruanganID;
    }

    public function render(PeminjamanService $service)
    {
        $data = $service->getDataWaktuPeminjaman($this->ruanganID);

        return view('livewire.user.peminjaman-per-ruangan', [
            'dates' => $data['dates'],
            'bookings' => $data['bookings'],
            'timeSlots' => $data['timeSlots'],
            'kodeRuangan' => $data['kodeRuangan']
        ]);
    }
}
