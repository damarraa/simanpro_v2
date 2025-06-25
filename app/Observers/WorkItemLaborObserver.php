<?php

namespace App\Observers;

use App\Models\WorkItemLabors;

class WorkItemLaborObserver
{
    /**
     * Handle the WorkItemLabors "created" event.
     */
    public function created(WorkItemLabors $workItemLabors): void
    {
        // Panggil method kalkulasi pada model induknya
        $workItemLabors->workItem->calculateAndUpdateCosts();
    }

    /**
     * Handle the WorkItemLabors "updated" event.
     */
    public function updated(WorkItemLabors $workItemLabors): void
    {
        // Panggil method kalkulasi pada model induknya
        $workItemLabors->workItem->calculateAndUpdateCosts();
    }

    /**
     * Handle the WorkItemLabors "deleted" event.
     */
    public function deleted(WorkItemLabors $workItemLabors): void
    {
        // Panggil method kalkulasi pada model induknya
        $workItemLabors->workItem->calculateAndUpdateCosts();
    }

    /**
     * Handle the WorkItemLabors "restored" event.
     */
    public function restored(WorkItemLabors $workItemLabors): void
    {
        //
    }

    /**
     * Handle the WorkItemLabors "force deleted" event.
     */
    public function forceDeleted(WorkItemLabors $workItemLabors): void
    {
        //
    }
}
