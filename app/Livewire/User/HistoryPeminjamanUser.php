<?php

namespace App\Livewire\User;

use App\Services\HistoryPeminjamanService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class HistoryPeminjamanUser extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterJenis = '';

    protected $queryString = [
        'search'       => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterJenis'  => ['except' => ''],
    ];

    public function updating()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset(['search', 'filterStatus', 'filterJenis']);
        $this->resetPage();
    }

    #[Computed]
    public function peminjaman()
    {
        return app(HistoryPeminjamanService::class)->getDataUser(
            session('user_identifier'),
            $this->getPage(),
            $this->search,
            $this->filterStatus,
            $this->filterJenis
        );
    }

    public function render()
    {
        return view('livewire.user.history-peminjaman-user', [
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
