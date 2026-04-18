<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditable;

class Database extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\TenantScope);
    }

    use Auditable;
    protected $fillable = [
        'server_id', 'name', 'type', 'connection_name',
        'host', 'port', 'username', 'password', 'database',
        'active_threshold', 'idle_threshold', 'lock_threshold',
        'status', 'is_active', 'organisation_id', 'branch_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? (bool) $value;
    }

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(DbMetric::class);
    }

    

    public function latestMetrics()
    {
        return $this->hasOne(DbMetric::class)->latestOfMany();
    }
}



