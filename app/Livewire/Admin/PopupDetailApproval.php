<?php

namespace App\Livewire\Admin;

use App\Services\ApproveRejectService;
use Livewire\Attributes\On;
use Livewire\Component;

class PopupDetailApproval extends Component
{
    public $isOpen = false;
    public $peminjamanId = null;
    public $peminjamanDetail = null;

    protected function service()
    {
        return new ApproveRejectService();
    }

    #[On('showApprovalDetail')]
    public function showDetail($id)
    {
        $this->peminjamanId = $id;
        $this->peminjamanDetail = (new \App\Services\ApprovalDataService())->getDetail($id);
        $this->isOpen = true;
    }

    public function closeDetail()
    {
        $this->isOpen = false;
        $this->peminjamanId = null;
        $this->peminjamanDetail = null;
    }

    public function approve()
    {
        if ($this->peminjamanId) {
            try {
                $this->service()->approve($this->peminjamanId);
                $this->closeDetail();
                $this->dispatch('refreshHistory');

                $this->dispatch('successApprove', text: 'Peminjaman berhasil diterima');
            } catch (\Exception $e) {
                $this->closeDetail();
                $this->dispatch('errorApproval', text: $e->getMessage());
            }
        }
    }

    public function reject($alasan)
    {
        if ($this->peminjamanId && $alasan) {
            try {
                $this->service()->reject($this->peminjamanId, $alasan);
                $this->closeDetail();
                $this->dispatch('refreshHistory');

                $this->dispatch('successReject', text: 'Peminjaman berhasil ditolak');
            } catch (\Exception $e) {
                $this->closeDetail();
                $this->dispatch('errorApproval', text: $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.popup-detail-approval');
    }
}
