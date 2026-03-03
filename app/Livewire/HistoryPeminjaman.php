<?php

namespace App\Livewire;

use App\Services\ApprovalService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DataPeminjaman;

class HistoryPeminjaman extends Component
{
    use WithPagination;

    public function render(ApprovalService $service)
    {
        return view('livewire.history-peminjaman', [
            'peminjaman' => $service->getData('historyPeminjaman', null),
        ]);
    }

    #[On('cancelBooking')]
    public function cancelBooking($id)
    {
        $data_peminjaman = DataPeminjaman::findOrFail($id);

        if ($data_peminjaman->status === 'Waiting') {
            $data_peminjaman->update(['status' => 'Canceled']);

            $this->dispatch('successCancel', [
                'text' => 'berhasil cancel booking'
            ]);
        }
    }
}
