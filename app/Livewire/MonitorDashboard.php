<?php

namespace App\Livewire;

use App\Services\DashboardService;
use Livewire\Component;
use Livewire\WithPagination;

class MonitorDashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public string $tab = 'akademik';
    protected $queryString = ['tab'];

    public function setTab(string $tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function render(DashboardService $dashboard)
    {
        return view('livewire.monitorDashboard', [
            'akademik' => $this->tab === 'akademik'
                ? $dashboard->ambilData('akademik')
                : collect(),

            'non_akademik' => $this->tab === 'non-akademik'
                ? $dashboard->ambilData('non-akademik')
                : collect(),
        ]);
    }
}
