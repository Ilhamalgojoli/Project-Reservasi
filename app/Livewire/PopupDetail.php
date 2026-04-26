<?php

namespace App\Livewire;

use App\Services\HistoryPeminjamanService;
use Livewire\Attributes\On;
use Livewire\Component;

class PopupDetail extends Component
{
    public $isOpen = false;
    public $detailId = null;

    #[On('showHistoryDetail')]
    public function showDetail($id)
    {
        $this->detailId = $id;
        $this->isOpen = true;
    }

    #[On('closeHistoryDetail')]
    public function closeDetail()
    {
        $this->isOpen = false;
        $this->detailId = null;
    }

    public function cancelReservation($reason = '-')
    {
        if ($this->detailId) {
            $service = new \App\Services\ApproveRejectService();
            # Jika role BAA, kita anggap dia admin (userIdentifier = null)
            # Jika bukan BAA, kita kirim NIM session untuk validasi kepemilikan
            $userIdentifier = (session('role_name') === 'BAA') ? null : session('user_identifier');

            try {
                $service->cancel($this->detailId, $userIdentifier, $reason);
                $this->dispatch('swal:success', text: 'Reservasi berhasil dibatalkan.');
            } catch (\Exception $e) {
                # Tampilkan pesan error/warning dari service (misal email gagal)
                $this->dispatch('swal:warning', text: $e->getMessage());
            }

            $this->closeDetail();
            $this->dispatch('refreshHistory');
        }
    }

    public function render()
    {
        $peminjamanDetail = null;
        if ($this->isOpen && $this->detailId) {
            $service = new HistoryPeminjamanService();
            $peminjamanDetail = $service->getDetail($this->detailId);
        }

        return view('livewire.popup-detail', [
            'peminjamanDetail' => $peminjamanDetail
        ]);
    }
}
