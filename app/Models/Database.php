<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditable;

class Database extends Model
{
    use Auditable;
    protected $fillable = [
        'server_id', 'name', 'type', 'connection_name',
        'host', 'port', 'username', 'password', 'database',
        'active_threshold', 'idle_threshold', 'lock_threshold',
        'status', 'is_active', 'role_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? (bool) $value;
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(DbMetric::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function latestMetrics()
    {
        return $this->hasOne(DbMetric::class)->latestOfMany();
    }
}