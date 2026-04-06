<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            $model->logAudit('create', null, $model->toArray());
        });

        static::updated(function ($model) {
            $model->logAudit('update', $model->getOriginal(), $model->getChanges());
        });

        static::deleted(function ($model) {
            $model->logAudit('delete', $model->toArray(), null);
        });
    }

    private function logAudit(string $action, ?array $oldValues, ?array $newValues): void
    {
        $user = Auth::user();
        
        AuditLog::create([
            'user_id' => $user?->id,
            'action' => $action,
            'entity_type' => static::class,
            'entity_id' => $this->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}