<?php

namespace App\Livewire\Admin;

use App\Models\Fakultas;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DataPeminjaman;

class CancelBooking extends Component
{
    use WithPagination;

    public ?int $detailId = null;
    public $search = '';
    public $filterFakultas = '';
    public $filterJenis = '';
    public $filterHari = '';
    public $showCancelModal = false;
    public $cancelId;
    public $cancelReason = '';

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
        $this->reset(['search', 'filterFakultas', 'filterJenis', 'filterHari']);
        $this->resetPage();
    }

    #[Computed]
    public function datas()
    {
        $service = app(\App\Services\ApprovalDataService::class);

        if ($this->detailId) {
            return $service->getApprovedDataById($this->detailId);
        }

        return $service->getApprovedData(
            $this->search,
            $this->filterFakultas,
            $this->filterJenis,
            $this->filterHari
        );
    }

    public function confirmCancel($id)
    {
        $this->cancelId = $id;
        $peminjaman = DataPeminjaman::find($id);
        if ($peminjaman && $peminjaman->cancel_requested) {
            $this->cancelReason = $peminjaman->cancel_request_reason;
        } else {
            $this->cancelReason = '';
        }
        $this->showCancelModal = true;
    }

    public function closeCancelModal()
    {
        $this->showCancelModal = false;
        $this->reset(['cancelId', 'cancelReason']);
    }

    public function processCancel()
    {
        $this->validate([
            'cancelReason' => 'required|min:5',
        ], [
            'cancelReason.required' => 'Alasan pembatalan wajib diisi',
            'cancelReason.min' => 'Alasan pembatalan minimal 5 karakter',
        ]);

        try {
            $service = app(\App\Services\ApproveRejectService::class);
            $service->cancel($this->cancelId, session('username'), $this->cancelReason, true);

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
            'fakultas' => Fakultas::all(),
            'jenis_peminjaman' => [
                'akademik' => 'Akademik',
                'non-akademik' => 'Non Akademik'
            ],
            'hari_list' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
        ]);
    }
}
