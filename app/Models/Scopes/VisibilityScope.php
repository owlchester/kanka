<?php

namespace App\Models\Scopes;

use App\Models\Visibility;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class VisibilityScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithInvisible'];

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the with-invisible extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return Builder
     */
    protected function addWithInvisible(Builder $builder)
    {
        $builder->macro('withInvisible', function (Builder $builder, $withInvisible = true) {
            if (! $withInvisible) {
                // Sends the default scope
                return $builder;
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model): Builder
    {
        // Only apply these scopes in non-console mode.
        if (app()->runningInConsole()) {
            return $builder;
        }

        // If we aren't authenticated, just see what is set to all
        if (auth()->guest()) {
            return $builder->where($model->getTable() . '.visibility', Visibility::VISIBILITY_ALL_STR);
        }

        // Either mine (self && created_by = me) or (if admin: !self, else: all)
        $builder->where(function ($sub) use ($model) {
            $visibilities = auth()->user()->isAdmin()
                ? [Visibility::VISIBILITY_ALL_STR, Visibility::VISIBILITY_ADMIN_STR,
                    Visibility::VISIBILITY_ADMIN_SELF_STR, Visibility::VISIBILITY_MEMBERS_STR]
                : [Visibility::VISIBILITY_ALL_STR, Visibility::VISIBILITY_MEMBERS_STR];
            $sub
                ->where(function ($self) use ($model) {
                    $self
                        ->whereIn($model->getTable() . '.visibility', [
                            Visibility::VISIBILITY_SELF_STR,
                            Visibility::VISIBILITY_ADMIN_SELF_STR,
                        ])
                        ->where($model->getTable() . '.created_by', auth()->user()->id);
                })
                ->orWhereIn($model->getTable() . '.visibility', $visibilities);
        });

        return $builder;
    }
}
