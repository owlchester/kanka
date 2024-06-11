<?php

namespace App\Models\Scopes;

use App\Models\Visibility;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PrivateScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // Only apply these scopes in non-console mode.
        if (app()->runningInConsole()) {
            return;
        }

        // If we aren't authenticated, just see what is set to all
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            $builder->where($model->getTable() . '.is_private', false);
        }
    }
}
