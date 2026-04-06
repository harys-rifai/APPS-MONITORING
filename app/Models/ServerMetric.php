<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerMetric extends Model
{
    protected $table = 'server_metrics';

    protected $fillable = [
        'server_id', 'cpu_usage', 'ram_usage', 'disk_usage',
        'network_in', 'network_out', 'is_active', 'role_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}