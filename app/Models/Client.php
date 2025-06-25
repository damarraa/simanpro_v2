<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'client_name',
        'client_contact_person',
        'client_phone',
    ];

    public function project(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
