<?php

namespace App\Livewire\Admin;

use App\Services\HistoryPeminjamanService;
use Livewire\Component;
use Livewire\WithPagination;

class HistoryPeminjamanAdmin extends Component
{
    use WithPagination;

    public function mount()
    {
        if (session('role_name') !== 'BAA') {
            abort(403);
        }

        if (session('token') === null) {
            abort(401);
        }
    }

    public function render(HistoryPeminjamanService $service)
    {
        return view('livewire.admin.history-peminjaman-admin', [
            'peminjaman' => $service->getDataAdmin($this->getPage())
        ]);
    }
}
