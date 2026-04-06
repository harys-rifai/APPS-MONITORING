<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Alert extends Model
{
    protected $fillable = [
        'alertable_type', 'alertable_id', 'type', 'status', 'message', 'metrics', 'is_active', 'role_id'
    ];

    protected $casts = [
        'metrics' => 'array',
        'is_active' => 'boolean',
    ];

    public function alertable(): MorphTo
    {
        return $this->morphTo();
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}