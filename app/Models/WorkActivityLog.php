<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkActivityLog extends Model
{
    protected $table = 'work_activity_logs';

    protected $fillable = [
        'realization_date',
        'realized_volume',
        'notes',
        'realization_docs_path',
        'control_docs_path',
        'work_item_id',
        'daily_project_report_id',
        'created_by',
    ];

    public function workItem(): BelongsTo
    {
        return $this->belongsTo(ProjectWorkItem::class, 'work_item_id');
    }

    public function dailyReport(): BelongsTo
    {
        return $this->belongsTo(DailyProjectReport::class, 'daily_project_report_id');
    }
}
