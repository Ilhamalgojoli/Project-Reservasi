<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class HistoryPeminjaman extends Component
{
    use WithPagination;

    protected function service()
    {
        return new \App\Services\HistoryPeminjamanService();
    }

    public function render()
    {
        $user_identifier = session('user_identifier');
        $user_role = session('role_name');

        return view('livewire.history-peminjaman', [
            'peminjaman' => $this->service()->getData($user_role, $user_identifier),
        ]);
    }

    #[On('cancelBooking')]
    public function cancelBooking($id, $alasan)
    {
        $user_role = session('role_name');
        $user_identifier = session('user_identifier');

        $data = [
            'id' => $id,
            'user_identifier' => $user_identifier,
            'user_role' => $user_role,
            'alasan' => $alasan
        ];

        try {
            $this->service()->cancel($data);

            $this->dispatch('successCancel', [
                'text' => 'berhasil membatalkan peminjaman'
            ]);
        } catch (\DomainException $e) {
            $this->dispatch('failedCancel', [
                'text' => $e->getMessage()
            ]);
        }
    }
}
