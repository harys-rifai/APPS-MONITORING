<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerMetric extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\TenantScope);
    }

    protected $table = 'server_metrics';

    protected $fillable = [
        'server_id', 'cpu_usage', 'ram_usage', 'disk_usage',
        'network_in', 'network_out', 'is_active', 'organisation_id', 'branch_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    
}


