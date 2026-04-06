<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Corporate extends Model
{
    protected $fillable = ['name', 'location', 'is_active', 'created_by'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function servers(): HasMany
    {
        return $this->hasMany(Server::class);
    }

    public function databases(): HasMany
    {
        return $this->hasMany(Database::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}