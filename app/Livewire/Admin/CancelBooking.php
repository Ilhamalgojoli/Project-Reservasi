<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\ApprovalDataService;
use App\Services\ApproveRejectService;
use \Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Pagination\Paginator;

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
            try {
                $detail = app(ApprovalDataService::class)->getDetail($this->detailId, 'approvedDetail');

                if ($detail->status !== 'Approve') {
                    throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
                }
                return new LengthAwarePaginator(
                    [$detail],
                    1,
                    10,
                    1,
                    ['path' => Paginator::resolveCurrentPath()]
                );
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return new LengthAwarePaginator(
                    [],
                    0,
                    10,
                    1,
                    ['path' => Paginator::resolveCurrentPath()]
                );
            }
        }

        return app(ApprovalDataService::class)->getApprovedData(
            $this->search,
            $this->filterJenis,
            $this->filterHari
        );
    }

    public function processCancel($cancelId, $cancelReason)
    {
        if (!$cancelId) {
            $this->dispatch('notValidIdCancel', 'Data peminjaman tidak valid');
            return;
        }

        if (empty($cancelReason) && trim($cancelReason) === '') {
            $this->dispatch('emptyStrCancel', 'Alasan penolakan tidak boleh kosong!');
            return;
        }

        try {
            app(ApproveRejectService::class)->cancel($cancelId, session('username'), $cancelReason, true);



            $this->dispatch('success', message: 'Peminjaman berhasil dibatalkan');
        } catch (\Exception $e) {
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
