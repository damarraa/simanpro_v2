<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetLocation extends Model
{
    use HasFactory;

    protected $table = 'asset_locations';
    
    protected $fillable = [
        'tool_id',
        'warehouse_id',
        'quantity',
        'last_moved_at'
    ];

    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
