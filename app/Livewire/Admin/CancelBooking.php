<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\ApprovalDataService;
use App\Services\ApproveRejectService;

class CancelBooking extends Component
{
    use WithPagination;

    public ?int $detailId = null;
    public $search = '';
    public $filterFakultas = '';
    public $filterJenis = '';
    public $filterHari = '';
    public $showCancelModal = false;

    protected $listeners = [
        'refreshApprovedPage' => 'render'
    ];

    protected $queryString = [
        'detailId' => ['except' => null],
        'search' => ['except' => ''],
        'filterFakultas' => ['except' => ''],
        'filterJenis' => ['except' => ''],
        'filterHari' => ['except' => ''],
    ];

    public function mount($detailId = null)
    {
        $this->detailId = $detailId ? (int) $detailId : null;
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset(['search', 'filterJenis', 'filterHari']);
        $this->resetPage();
    }

    #[Computed]
    public function datas()
    {
        if ($this->detailId) {
            return app(ApprovalDataService::class)->getDetail($this->detailId, 'approvedDetail');
        }

        return app(ApprovalDataService::class)->getApprovedData(
            $this->search,
            $this->filterJenis,
            $this->filterHari
        );
    }

    public function processCancel($cancelId, $cancelReason)
    {
        if(!$cancelId){
            $this->dispatch('notValidIdCancel', 'Data peminjaman tidak valid'); 
            return;
        }

        if (empty($cancelReason) && trim($cancelReason) === '') {
            $this->dispatch('emptyStrCancel', 'Alasan penolakan tidak boleh kosong!');
            return;
        }

        try {
            app(ApproveRejectService::class)->cancel($cancelId, session('username'), $cancelReason, true);

            $this->closeCancelModal();
            $this->dispatch('success', message: 'Reservasi berhasil dibatalkan');
        } catch (\Exception $e) {
            $this->closeCancelModal();
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.cancel-booking', [
            'datas' => $this->datas,
            'jenis_peminjaman' => [
                'akademik' => 'Akademik',
                'non-akademik' => 'Non Akademik'
            ],
            'hari_list' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
        ]);
    }
}
