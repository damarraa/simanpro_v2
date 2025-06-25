<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class WorkItemMaterials extends Model
{
    protected $table = 'work_item_materials';

    protected $fillable = [
        'material_name',
        'quantity',
        'unit',
        'unit_price',
        'work_item_id',
    ];

    public function workItem(): BelongsTo
    {
        return $this->belongsTo(ProjectWorkItem::class, 'work_item_id');
    }

    // public function calculateAndUpdateCosts(): void
    // {
    //     $totalMaterialCost = $this->workItemMaterials()->sum(DB::raw('quantity * unit_price'));
    //     $totalLaborCost = $this->workItemLabors()->sum(DB::raw('quantity * rate'));

    //     $this->unit_price = $totalMaterialCost + $totalLaborCost;
    //     $this->total_planned_amount = $this->unit_price * $this->volume;
    //     $this->saveQuietly(); // Gunakan saveQuietly() untuk menghindari infinite loop observer
    // }
}
