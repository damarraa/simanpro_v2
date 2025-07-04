<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $table = 'maintenance_logs';

    protected $fillable = [
        'vehicle_id',
        'maintenance_date',
        'odometer',
        'type',
        'location',
        'notes',
        'docs_path',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
