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

    public $search = '';
    public $jenis_peminjaman = '';
    public $filterStatus = '';
    
    protected $queryString = [
        'search'           => ['except' => ''],
        'fakultas_id'      => ['except' => ''],
        'jenis_peminjaman' => ['except' => ''],
        'filterStatus'     => ['except' => ''],
    ];

    public function updating()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset(['search', 'jenis_peminjaman', 'filterStatus']);
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
        return app(HistoryPeminjamanService::class)->getDataAdmin(
            $this->getPage(),
            $this->jenis_peminjaman,
            $this->search,
            $this->filterStatus,
        );
    }

    public function render()
    {
        return view('livewire.admin.history-peminjaman-admin', [
            'peminjaman' => $this->peminjaman,
            'jenisPeminjaman' => [
                'akademik' => 'akademik',
                'non-akademik' => 'non-akademik'
            ],
            'status' => [
                'Reject' => 'ditolak',
                'Canceled' => 'dibatalkan',
                'Finish' => 'selesai'
            ]
        ]);
    }
}
