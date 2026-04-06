<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name', 'description', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission(string $permission): bool
    {
        $allPermissions = [
            'admin' => ['servers.*', 'databases.*', 'alerts.*', 'users.*', 'audit_logs.*'],
            'operator' => ['servers.*', 'databases.*', 'alerts.*'],
            'viewer' => ['servers.view', 'databases.view', 'alerts.view'],
        ];

        $rolePerms = $allPermissions[$this->name] ?? [];
        
        if (in_array('*', $rolePerms)) {
            return true;
        }

        foreach ($rolePerms as $perm) {
            if (str_ends_with($perm, '.*')) {
                $prefix = rtrim($perm, '.*');
                if (str_starts_with($permission, $prefix)) {
                    return true;
                }
            }
            if ($perm === $permission) {
                return true;
            }
        }

        return false;
    }
}