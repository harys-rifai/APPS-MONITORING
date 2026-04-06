<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Alert extends Model
{
    public const SEVERITY_INFO = 'info';
    public const SEVERITY_WARNING = 'warning';
    public const SEVERITY_CRITICAL = 'critical';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_RESOLVED = 'resolved';

    protected $fillable = [
        'alertable_type', 'alertable_id', 'type', 'status', 'severity', 'message', 'metrics', 'is_active', 'role_id', 'group_key', 'resolved_at'
    ];

    protected $casts = [
        'metrics' => 'array',
        'is_active' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    public function alertable(): MorphTo
    {
        return $this->morphTo();
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isCritical(): bool
    {
        return $this->severity === self::SEVERITY_CRITICAL;
    }

    public function isResolved(): bool
    {
        return $this->status === self::STATUS_RESOLVED;
    }
}