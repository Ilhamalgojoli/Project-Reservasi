<?php

namespace App\Livewire;

use App\Services\HistoryPeminjamanService;
use Livewire\Component;
use Livewire\WithPagination;

class HistoryPeminjamanUser extends Component
{
    use WithPagination;

    protected function service()
    {
        return new HistoryPeminjamanService();
    }

    public function render()
    {
        return view('livewire.history-peminjaman-user', [
            'peminjaman' => $this->service()->getDataUser(session('user_identifier')),
        ]);
    }
}
