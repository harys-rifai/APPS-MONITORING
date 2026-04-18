<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::hasUser()) {
            $user = Auth::user();

            if ($user->hasRole('Admin')) {
                // Admin can see everything in their organisation
                $builder->where($model->getTable() . '.organisation_id', $user->organisation_id);
            } elseif ($user->hasRole('Branch Manager')) {
                // Branch Manager sees everything in their branch
                $builder->where($model->getTable() . '.organisation_id', $user->organisation_id)
                        ->where($model->getTable() . '.branch_id', $user->branch_id);
            } elseif ($user->hasRole('Line Manager') || $user->hasRole('Supervisor')) {
                // Same as Branch Manager or maybe they only see their direct reports?
                // The agents.md says roles must be hierarchical but isolated per organization.
                // Let's scope to branch for these as well, and use Policies for finer control over users.
                $builder->where($model->getTable() . '.organisation_id', $user->organisation_id)
                        ->where($model->getTable() . '.branch_id', $user->branch_id);
            } else {
                // User
                $builder->where($model->getTable() . '.organisation_id', $user->organisation_id)
                        ->where($model->getTable() . '.branch_id', $user->branch_id);
            }
        }
    }
}
