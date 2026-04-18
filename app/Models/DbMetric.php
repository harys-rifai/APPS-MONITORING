<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DbMetric extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\TenantScope);
    }

    protected $table = 'db_metrics';

    protected $fillable = [
        'database_id', 'active_count', 'idle_count', 'locked_count', 'is_active', 'organisation_id', 'branch_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function database(): BelongsTo
    {
        return $this->belongsTo(Database::class);
    }

    
}


