<?php

namespace App\Livewire;

use App\Models\DataPeminjaman;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ApproveRejectBooking extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    protected function service()
    {
        return new \App\Services\ApprovalService;
    }

    #[On('approve')]
    public function approve($id)
    {
        if (isset($id) || is_numeric($id)) {
            $this->service()->approve($id);

            $this->resetPage();
            $this->dispatch('successApprove', [
                'text' => 'Peminjaman berhasil diterima',
            ]);
        }
    }

    #[On('reject')]
    public function reject($id, $alasan)
    {
        if (isset($id) || is_numeric($id)) {
            $this->service()->reject($id, $alasan);

            $this->resetPage();
            $this->dispatch('successReject', [
                'text' => 'Peminjaman berhasil ditolak',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.approve-reject-booking', [
            'peminjaman' => $this->service()->getData('approvePage', $this->search),
        ]);
    }
}
