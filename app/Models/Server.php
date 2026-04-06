<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Server extends Model
{
    protected $fillable = [
        'name', 'hostname', 'ip', 'os', 'type',
        'cpu_threshold', 'ram_threshold', 'disk_threshold', 'network_threshold',
        'location', 'api_token', 'is_active', 'role_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function initialize()
    {
        $this->attributes['is_active'] = $this->is_active ? true : false;
    }

    protected function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = $value === true || $value === 'true' || $value === 1 || $value === '1';
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