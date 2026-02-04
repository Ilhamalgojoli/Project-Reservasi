<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DataPeminjaman;

class HistoryPeminjaman extends Component
{
    use WithPagination;

    public function render()
    {
        $get_data = new ApproveRejectBooking;

        return view('livewire.history-peminjaman', [
            'peminjaman' => $get_data->getData('historyPeminjaman'),
        ]);
    }

    #[On('cancelBooking')]
    public function cancelBooking($id)
    {
        $data_peminjaman = DataPeminjaman::findOrFail($id);

        if ($data_peminjaman->status === 'Waiting') {
            $data_peminjaman->delete();

            $this->dispatch('successCancel', [
                'text' => 'berhasil cancel booking'
            ]);
        }
    }
}
