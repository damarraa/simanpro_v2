<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    use HasFactory;

    protected $table = 'tools';
    
    protected $fillable = [
        'tool_code',
        'name',
        'brand',
        'serial_number',
        'purchase_date',
        'unit_price',
        'condition',
        'warranty_period',
        'picture_path'
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(AssetLocation::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class);
    }
}
