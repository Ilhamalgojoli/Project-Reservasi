<?php

namespace App\Livewire\Admin;

use App\Services\ApproveRejectService;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\ApprovalDataService;

class PopupDetailApproval extends Component
{
    public $isOpen = false;
    public $peminjamanId = null;
    public $peminjamanDetail = null;

    # Ini untuk detail approval kalau data masih ber status waiting
    #[On('showApprovalDetail')]
    public function showDetail($id)
    {
        $this->peminjamanId = $id;
        $this->peminjamanDetail = app(ApprovalDataService::class)->getDetail($id);
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
                app(ApproveRejectService::class)->approve($this->peminjamanId);
                $this->closeDetail();
                $this->dispatch('refreshApprove');

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
                app(ApproveRejectService::class)->reject($this->peminjamanId, $alasan);
                $this->closeDetail();
                $this->dispatch('refreshReject');

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
