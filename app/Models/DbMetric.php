<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DbMetric extends Model
{
    protected $table = 'db_metrics';

    protected $fillable = [
        'database_id', 'active_count', 'idle_count', 'locked_count', 'is_active', 'role_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function database(): BelongsTo
    {
        return $this->belongsTo(Database::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}