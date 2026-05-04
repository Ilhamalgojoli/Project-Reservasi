<?php

namespace App\Livewire\Admin;

use App\Models\DataPeminjaman;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class CancelBooking extends Component
{
    use WithPagination;

    public $search = '';
    public $showCancelModal = false;
    public $cancelId;
    public $cancelReason = '';

    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Computed]
    public function datas()
    {
        $service = app(\App\Services\ApprovalDataService::class);
        return $service->getApprovedData($this->search);
    }

    public function confirmCancel($id)
    {
        $this->cancelId = $id;
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
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.cancel-booking', [
            'datas' => $this->datas // Memanggil Computed Property
        ]);
    }
}
