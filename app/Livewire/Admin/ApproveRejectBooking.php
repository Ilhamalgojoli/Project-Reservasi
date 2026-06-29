<?php

namespace App\Livewire\Admin;

use App\Models\Fakultas;
use App\Services\ApprovalDataService;
use Livewire\Component;
use Livewire\WithPagination;

class ApproveRejectBooking extends Component
{
    use WithPagination;

    public $search = '';
    public $filterFakultas = '';
    public $filterJenis = '';
    public $filterHari = '';

    protected $listeners = [
        'refreshTableKelolaApprove' => 'render',
        'refreshTableKelolaReject' => 'render'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterFakultas' => ['except' => ''],
        'filterJenis' => ['except' => ''],
        'filterHari' => ['except' => ''],
    ];

    public function updating()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset(['search', 'filterJenis', 'filterHari']);
        $this->resetPage();
    }

    public function mount()
    {
        if (session('role_name') !== 'BAA') {
            abort(403);
        }
    }

    public function render()
    {
        $data = app(ApprovalDataService::class)->getData(
            $this->search,
            $this->filterJenis,
            $this->filterHari
        );

        return view('livewire.admin.approve-reject-booking', [
            'peminjaman' => $data,
            'jenis_peminjaman' => [
                'akademik' => 'Akademik',
                'non-akademik' => 'Non Akademik'
            ],
            'hari_list' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
        ]);
    }
}
