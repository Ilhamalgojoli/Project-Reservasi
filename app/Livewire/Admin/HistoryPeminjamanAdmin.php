<?php

namespace App\Livewire\Admin;

use App\Models\Fakultas;
use App\Services\HistoryPeminjamanService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class HistoryPeminjamanAdmin extends Component
{
    use WithPagination;

    public $fakultas_id = '';
    public $jenis_peminjaman = '';

    public function updatingFakultasId()
    {
        $this->resetPage();
    }

    public function updatingJenisPeminjaman()
    {
        $this->resetPage();
    }

    public function mount()
    {
        if (session('role_name') !== 'BAA') {
            abort(403);
        }

        if (session('token') === null) {
            abort(401);
        }
    }

    #[Computed]
    public function peminjaman()
    {
        $service = app(HistoryPeminjamanService::class);
        return $service->getDataAdmin($this->getPage(), $this->fakultas_id, $this->jenis_peminjaman);
    }

    #[Computed]
    public function fakultasList()
    {
        return Fakultas::orderBy('fakultas')->get();
    }

    public function render()
    {
        return view('livewire.admin.history-peminjaman-admin', [
            'peminjaman' => $this->peminjaman
        ]);
    }
}
