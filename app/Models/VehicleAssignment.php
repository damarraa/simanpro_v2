<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleAssignment extends Model
{
    use HasFactory;

    protected $table = 'vehicle_assignments';

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'project_id',
        'start_datetime',
        'end_datetime',
        'start_odometer',
        'end_odometer',
        'notes'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
