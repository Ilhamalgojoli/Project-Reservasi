<?php

namespace App\Livewire\Admin;

use App\Models\Lantai;
use App\Services\DashboardService;
use Livewire\Component;
use Livewire\WithPagination;

class MonitorDashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public string $tab = 'matkul-wajib';
    public string $selectedLantai = '';
    public string $selectedStatus = '';

    protected $queryString = [
        'tab' => ['except' => 'matkul-wajib'],
        'selectedLantai' => ['except' => ''],
        'selectedStatus' => ['except' => '']
    ];

    public function setTab(string $tab)
    {
        $this->tab = $tab;
        $this->selectedLantai = '';
        $this->selectedStatus = '';
        $this->resetPage('pageMatkulWajib');
        $this->resetPage('pageAkademik');
        $this->resetPage('pageNonAkademik');
    }

    public function updatedSelectedLantai()
    {
        $this->resetPage('pageMatkulWajib');
    }

    public function updatedSelectedStatus()
    {
        $this->resetPage('pageMatkulWajib');
    }

    public function render(DashboardService $dashboard)
    {
        return view('livewire.admin.monitorDashboard', [
            'matkul_wajib' => $this->tab === 'matkul-wajib'
                ? $dashboard->ambilDataMatkulWajib($this->selectedLantai, $this->selectedStatus)
                : collect(),

            'akademik' => $this->tab === 'akademik'
                ? $dashboard->ambilData('akademik')
                : collect(),

            'non_akademik' => $this->tab === 'non-akademik'
                ? $dashboard->ambilData('non-akademik')
                : collect(),

            'list_lantai' => Lantai::select('lantai')->distinct()->orderBy('lantai')->get(),
        ]);
    }
}
