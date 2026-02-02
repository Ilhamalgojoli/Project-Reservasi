<?php

namespace App\Livewire;

use App\Http\Controllers\GetDataPeminjaman;
use Livewire\Component;

class HistoryPeminjaman extends Component
{
    public function render()
    {
        $get_data = new GetDataPeminjaman();

        return view('livewire.history-peminjaman', [
            'peminjaman' => $get_data->getData('historyPeminjaman')
        ]);
    }
}
