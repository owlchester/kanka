<?php

namespace App\Models\Scopes;

use App\Models\Visibility;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PrivateScope implements Scope
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
        // Only apply these scopes in non-console mode.
        if (app()->runningInConsole()) {
            // However, if we are in console mode (exporting), we need a way to avoid people accessing "self" notes.
            // Todo: how to handle this use case properly? Not exporting "self" seems silly
            // $builder->where($model->getTable() . 'visibility', '!=', Visibility::VISIBILITY_SELF);
            return;
        }

        // If we aren't authenticated, just see what is set to all
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            $builder->where($model->getTable() . '.is_private', false);
        }
    }
}
