<?php

namespace App\Observers;

use App\Models\WorkItemMaterials;
use Illuminate\Support\Facades\Log;

class WorkItemMaterialObserver
{
    /**
     * Handle the WorkItemMaterials "created" event.
     */
    public function created(WorkItemMaterials $workItemMaterials): void
    {
        // Panggil method kalkulasi pada model induknya
        Log::info('Observer untuk WorkItemMaterial TERPANGGIL untuk item ID: ' . $workItemMaterials->id);
        $workItemMaterials->workItem->calculateAndUpdateCosts();
    }

    /**
     * Handle the WorkItemMaterials "updated" event.
     */
    public function updated(WorkItemMaterials $workItemMaterials): void
    {
        // Panggil method kalkulasi pada model induknya
        $workItemMaterials->workItem->calculateAndUpdateCosts();
    }

    /**
     * Handle the WorkItemMaterials "deleted" event.
     */
    public function deleted(WorkItemMaterials $workItemMaterials): void
    {
        // Panggil method kalkulasi pada model induknya
        $workItemMaterials->workItem->calculateAndUpdateCosts();
    }

    /**
     * Handle the WorkItemMaterials "restored" event.
     */
    public function restored(WorkItemMaterials $workItemMaterials): void
    {
        //
    }

    /**
     * Handle the WorkItemMaterials "force deleted" event.
     */
    public function forceDeleted(WorkItemMaterials $workItemMaterials): void
    {
        //
    }
}
