<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PrivateScope implements Scope
{
    protected $extensions = ['WithPrivate'];

    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithPrivate(Builder $builder)
    {
        $builder->macro('withPrivate', function (Builder $builder, $withInvisible = true) {
            if (!$withInvisible) {
                // Sends the default scope
                return $builder;
            }

            // @phpstan-ignore-next-line
            return $builder->withoutGlobalScope($this);
        });
    }

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
