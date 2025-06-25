<?php

namespace App\Providers;

use App\Models\WorkItemLabors;
use App\Models\WorkItemMaterials;
use App\Observers\WorkItemLaborObserver;
use App\Observers\WorkItemMaterialObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        WorkItemMaterials::observe(WorkItemMaterialObserver::class);
        WorkItemLabors::observe(WorkItemLaborObserver::class);
    }
}
