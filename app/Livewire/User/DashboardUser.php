<?php

namespace App\Livewire\User;

use App\Services\ApproveRejectService;
use App\Services\DashboardUserService;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardUser extends Component
{
    public function render()
    {
        return view('livewire.user.dashboard-user', 
            (new DashboardUserService())->getDashboardData(session('user_identifier'))
        );
    }

    public function confirmCancel($id)
    {
        $this->dispatch('open-cancel-modal', id: $id);
    }

    #[On('cancelBooking')]
    public function cancelBooking($id, $alasan)
    {
        try {
            # Ambil user identifier dari session
            $userIdentifier = session('user_identifier');
            
            # Panggil service dengan parameter yang benar (id, user_identifier, alasan)
            (new ApproveRejectService())->cancel($id, $userIdentifier, $alasan);

            $this->dispatch('successCancel', ['text' => 'berhasil membatalkan peminjaman']);
        } catch (\Exception $e) {
            $this->dispatch('failedCancel', ['text' => $e->getMessage()]);
        }
    }
}
