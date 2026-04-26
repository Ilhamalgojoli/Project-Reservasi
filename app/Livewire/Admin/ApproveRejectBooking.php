<?php

namespace App\Livewire\Admin;

use App\Services\ApprovalDataService;
use Livewire\Component;
use Livewire\WithPagination;

class ApproveRejectBooking extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];
    private $data = [];

    public function mount()
    {
        if (session('role_name') !== 'BAA') {
            abort(403);
        }
    }


    public function render(ApprovalDataService $service)
    {
        $this->data = $service->getData($this->search);

        return view('livewire.admin.approve-reject-booking', [
            'peminjaman' => $this->data,
        ]);
    }
}
