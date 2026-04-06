<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;

class Server extends Model
{
    use Auditable;
    protected $fillable = [
        'name', 'hostname', 'ip', 'os', 'type',
        'cpu_threshold', 'ram_threshold', 'disk_threshold', 'network_threshold',
        'location', 'api_token', 'is_active', 'role_id', 'corporate_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function corporate(): BelongsTo
    {
        return $this->belongsTo(Corporate::class);
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

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
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