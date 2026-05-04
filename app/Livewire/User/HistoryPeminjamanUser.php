<?php

namespace App\Livewire\User;

use App\Services\HistoryPeminjamanService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class HistoryPeminjamanUser extends Component
{
    use WithPagination;

    #[Computed]
    public function peminjaman()
    {
        $service = new HistoryPeminjamanService();
        return $service->getDataUser(session('user_identifier'), $this->getPage());
    }

    public function render()
    {
        return view('livewire.user.history-peminjaman-user', [
            'peminjaman' => $this->peminjaman,
        ]);
    }
}
