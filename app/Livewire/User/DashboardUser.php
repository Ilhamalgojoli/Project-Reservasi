<?php

namespace App\Livewire\User;

use App\Models\DataPeminjaman;
use App\Services\ApproveRejectService;
use App\Services\DashboardUserService;
use App\Services\NotificationService;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardUser extends Component
{
    public function render(DashboardUserService $userService)
    {
        return view(
            'livewire.user.dashboard-user',
            $userService->getDashboardData(session('user_identifier'))
        );
    }

    public function confirmCancel($id)
    {
        $this->dispatch('open-cancel-modal', id: $id);
    }

    public function confirmRequestCancel($id)
    {
        $this->dispatch('confirmRequestCancel', id: $id);
    }

    #[On('cancelBooking')]
    public function cancelBooking($id, $alasan)
    {
        try {
            $userIdentifier = session('user_identifier');

            (new ApproveRejectService())->cancel($id, $userIdentifier, $alasan);

            $this->dispatch('successCancel', text: 'Peminjaman berhasil dibatalkan.');
        } catch (\Exception $e) {
            $this->dispatch('failedCancel', text: $e->getMessage());
        }
    }

    #[On('requestCancelBooking')]
    public function requestCancelBooking($peminjamanId, $alasan = '')
    {
        try {
            $peminjaman = DataPeminjaman::with('ruangan')->findOrFail($peminjamanId);
            $peminjaman->pembatalan()->updateOrCreate(
                ['data_peminjaman_id' => $peminjaman->id],
                [
                    'cancel_requested' => true,
                    'cancel_request_reason' => $alasan
                ]
            );

            (new NotificationService())->pushKegiatanTerkini(
                $peminjaman->penanggung_jawab,
                $peminjaman->ruangan_id,
                'CancelRequest',
                $peminjaman->id,
                $alasan
            );

            $this->dispatch('successCancel', text: 'Permintaan pembatalan peminjaman berhasil dikirim. Admin akan segera meninjau permohonan Anda.');
        } catch (\Exception $e) {
            $this->dispatch('failedCancel', text: $e->getMessage() ?: 'gagal mengirim permintaan pembatalan peminjaman');
        }
    }
}
