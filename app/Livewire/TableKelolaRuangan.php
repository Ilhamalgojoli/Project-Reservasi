<?php

namespace App\Livewire;

use App\Services\RuanganService;
use Livewire\Component;
use Livewire\WithPagination;

class TableKelolaRuangan extends Component
{
    use WithPagination;
    public $gedungID;
    public $search = '';
    protected $queryString = ['search'];
    private $filter = false;
    private $id;

    protected $listeners = [
        'filterButton' => 'filterListener'
    ];

    public function mount($id)
    {   
        $this->gedungID = $id;
    }

    public function filterListener($id)
    {
        $this->filter = true;
        $this->id = $id;
    }

    public function render(RuanganService $service)
    {
        return view('livewire.table-kelola-ruangan', [
            'datas' => $service->getData($this->gedungID, $this->search, $this->filter, $this->id),
        ]);
    }
}
