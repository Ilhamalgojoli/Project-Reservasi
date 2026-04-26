<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class DashboardAdmin extends Component
{
    public function mount()
    {
        if (session('role_name') !== 'BAA') {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin');
    }
}
