<?php

namespace App\Livewire\Admin;

use App\Services\RuanganService;
use Livewire\Component;
use Livewire\WithPagination;

class TableKelolaRuangan extends Component
{
    use WithPagination;
    
    public $gedungID;
    public $search = '';
    public $filter = false;
    public $filterID = null;

    protected $queryString = ['search'];

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
        $this->filterID = $id;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(RuanganService $service)
    {
        return view('livewire.admin.table-kelola-ruangan', [
            'datas' => $service->getData($this->gedungID, $this->search, $this->filter, $this->filterID),
        ]);
    }
}
