<?php

namespace App\Livewire;

use App\Models\Ruangan;
use Livewire\Component;
use Livewire\WithPagination;

class TableKelolaRuangan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    public $gedungID;

    public function mount($id)
    {   
        $this->gedungID = $id;
    }

    public function render()
    {
        $datas = Ruangan::with([
            'lantai:id,lantai,gedung_id',
            'asset:ruangan_id,nama_asset,jumlah_asset',
        ])
            ->select('id', 'kode_ruangan', 'status', 'muatan_kapasitas', 'lantai_id')
            ->whereHas('lantai', function ($q) {
                $q->where('gedung_id', $this->gedungID);
            })
            ->paginate(5);

        return view('livewire.table-kelola-ruangan', [
            'datas' => $datas,
        ]);
    }
}
