<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetAssignment extends Model
{
    use HasFactory;

    protected $table = 'asset_assignments';
    
    protected $fillable = [
        'tool_id',
        'project_id',
        'assigned_by',
        'assigned_date',
        'returned_date',
        'notes'
    ];

    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
