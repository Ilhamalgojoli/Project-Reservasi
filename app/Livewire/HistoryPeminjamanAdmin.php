<?php

namespace App\Livewire;

use App\Services\HistoryPeminjamanService;
use Livewire\Component;
use Livewire\WithPagination;

class HistoryPeminjamanAdmin extends Component
{
    use WithPagination;

    public function render(HistoryPeminjamanService $service)
    {
        return view('livewire.history-peminjaman-admin', [
            'peminjaman' => $service->getDataAdmin()
        ]);
    }
}
