<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;

class Server extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\TenantScope);
    }

    use Auditable;
protected $fillable = [
        'name', 'hostname', 'ip', 'os', 'type',
        'cpu_threshold', 'ram_threshold', 'disk_threshold', 'network_threshold',
        'location', 'api_token', 'is_active', 'organisation_id', 'branch_id',
        'ping_status', 'pinged_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'pinged_at' => 'datetime',
    ];

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function setIsActiveAttribute($value): void
    {
        $this->attributes['is_active'] = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? (bool) $value;
    }

    public function databases(): HasMany
    {
        return $this->hasMany(Database::class);
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(ServerMetric::class);
    }

    

    public function latestMetrics()
    {
        return $this->hasOne(ServerMetric::class)->latestOfMany();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', true);
    }
}



