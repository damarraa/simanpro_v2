<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class WorkItemMaterials extends Model
{
    protected $table = 'work_item_materials';

    protected $fillable = [
        'material_id',
        'quantity',
        'unit',
        'unit_price',
        'work_item_id',
    ];

    public function workItem(): BelongsTo
    {
        return $this->belongsTo(ProjectWorkItem::class, 'work_item_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
