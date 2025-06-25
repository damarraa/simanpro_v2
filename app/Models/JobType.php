<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobType extends Model
{
    protected $table = 'job_types';

    protected $fillable = [
        'job_type'
    ];

    public function project(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
