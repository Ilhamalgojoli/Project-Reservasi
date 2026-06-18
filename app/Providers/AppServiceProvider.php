<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GedungService;
use App\Services\PeminjamanService;
use App\Services\ApproveRejectService;
use App\Services\HistoryPeminjamanService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GedungService::class);
        $this->app->singleton(PeminjamanService::class);
        $this->app->singleton(ApproveRejectService::class);
        $this->app->singleton(HistoryPeminjamanService::class);
    }

    public function boot(): void
    {

    }
}
