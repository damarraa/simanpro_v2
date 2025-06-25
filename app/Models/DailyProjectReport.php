<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailyProjectReport extends Model
{
    protected $table = 'daily_project_reports';

    protected $fillable = [
        'report_date',
        'weather',
        'personnel_count',
        'start_time',
        'end_time',
        'notes',
        'submitted_by',
        'project_id',
        'user_id'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function workActivities(): HasMany
    {
        return $this->hasMany(WorkActivityLog::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
