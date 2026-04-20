<?php

namespace App\Livewire;

use App\Services\DashboardUserService;
use App\Services\PeminjamanService;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardUser extends Component
{
    protected function service()
    {
        return new DashboardUserService();
    }

    public function render()
    {
        return view('livewire.dashboard-user', 
            $this->service()->getDashboardData(session('user_identifier'))
        );
    }

    public function confirmCancel($id)
    {
        $this->dispatch('open-cancel-modal', id: $id);
    }

    #[On('cancelBooking')]
    public function cancelBooking($id, $alasan)
    {
        $data = [
            'id'              => $id,
            'user_identifier' => session('user_identifier'),
            'user_role'       => session('role_name'),
            'alasan'          => $alasan,
        ];

        try {
            (new PeminjamanService())->cancel($data);

            $this->dispatch('successCancel', ['text' => 'berhasil membatalkan peminjaman']);
        } catch (\DomainException $e) {
            $this->dispatch('failedCancel', ['text' => $e->getMessage()]);
        }
    }
}
