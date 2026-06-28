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

    public function render()
    {
        return view('livewire.admin.monitorDashboard', [
            'matkul_wajib' => $this->tab === 'matkul-wajib'
                ? app(DashboardService::class)->ambilDataMatkulWajib($this->selectedLantai, $this->selectedStatus)
                : collect(),

            'akademik' => $this->tab === 'akademik'
                ? app(DashboardService::class)->ambilData('akademik', $this->selectedLantai, $this->selectedStatus)
                : collect(),

            'non_akademik' => $this->tab === 'non-akademik'
                ? app(DashboardService::class)->ambilData('non-akademik', $this->selectedLantai, $this->selectedStatus)
                : collect(),

            'list_lantai' => Lantai::select('lantai')->distinct()->orderBy('lantai')->get(),
        ]);
    }
}
