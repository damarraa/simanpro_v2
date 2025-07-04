<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';

    protected $fillable = [
        'name',
        'vehicle_type',
        'merk',
        'model',
        'license_plate',
        'purchase_year',
        'capacity',
        'vehicle_license',
        'license_expiry_date',
        'vehicle_identity_number',
        'engine_number',
        'tax_due_date',
        'notes',
        'docs_path',
        'pic_user_id'
    ];

    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class, 'vehicle_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(VehicleAssignment::class, 'vehicle_id');
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }
}
