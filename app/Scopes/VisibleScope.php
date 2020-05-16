<?php

namespace App\Scopes;

use App\Facades\EntityPermission;
use App\Models\CampaignPermission;
use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VisibleScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!app()->runningInConsole()) {
            if (!Auth::check() || !Auth::user()->isAdmin()) {
                $builder->where($model->getTable() . '.is_private', false);

                // If the user is part of a role which has a blanket access to this entity type, we're good.
                // But if they are not, we need to get individual permissions
                // If one of the user's roles can read all entities of this type, there
                // is no need to check further.
                if ($model instanceof MiscModel && !empty($model->getEntityType())) {
                    $deniedEntityIds = EntityPermission::deniedEntityIds($model->getEntityType());
                    if (!EntityPermission::canRole('read', $model->getEntityType(), auth()->user())) {
                        $entityIds = EntityPermission::entityIds($model->getEntityType());

                        $primaryKey = !empty($model->aclFieldName) ? $model->aclFieldName : 'id';
                        $builder
                            ->whereIn($model->getTable() . '.' . $primaryKey, $entityIds)
                            ->whereNotIn($model->getTable() . '.' . $primaryKey, $deniedEntityIds);
                    } elseif (!empty($deniedEntityIds)) {
                        $primaryKey = !empty($model->aclFieldName) ? $model->aclFieldName : 'id';
                        $builder->whereNotIn($model->getTable() . '.' . $primaryKey, $deniedEntityIds);
                    }
                }
            }
        }
    }
}
