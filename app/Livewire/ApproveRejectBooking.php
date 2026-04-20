<?php

namespace App\Livewire;

use App\Services\ApprovalService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ApproveRejectBooking extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];
    private $data = [];

    protected function service()
    {
        return new ApprovalService();
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
        $this->data = $this->service()->getData($this->search);

        return view('livewire.approve-reject-booking', [
            'peminjaman' => $this->data,
        ]);
    }
}
