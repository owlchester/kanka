<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VisibilityScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithInvisible'];

    /**
     * Visibility constants
     */
    const VISIBILITY_ALL = 'all';
    const VISIBILITY_ADMIN = 'admin';
    const VISIBILITY_MEMBERS = 'members';
    const VISIBILITY_SELF = 'self';
    const VISIBILITY_ADMIN_SELF = 'admin-self';

    public function scopeWithInvisible(Builder $builder): self
    {
        dd('wo');
        return $this;
    }

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
     * @return void
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
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // Only apply these scopes in non-console mode.
        if (!app()->runningInConsole()) {
            // If we aren't authenticated, just see what is set to all
            if (!Auth::check()) {
                $builder->where($model->getTable() . '.visibility', self::VISIBILITY_ALL);
            } else {
                // Either mine (self && created_by = me) or (if admin: !self, else: all)
                $builder->where(function ($sub) use ($model) {
                    $visibilities = auth()->user()->isAdmin()
                        ? [self::VISIBILITY_ALL, self::VISIBILITY_ADMIN,
                            self::VISIBILITY_ADMIN_SELF, self::VISIBILITY_MEMBERS]
                        : [self::VISIBILITY_ALL, self::VISIBILITY_MEMBERS];
                    $sub
                        ->where(function ($self) use ($model) {
                            $self
                                ->whereIn($model->getTable() . '.visibility', [
                                    self::VISIBILITY_SELF,
                                    self::VISIBILITY_ADMIN_SELF,
                                ])
                                ->where($model->getTable() . '.created_by', auth()->user()->id);
                        })
                        ->orWhereIn($model->getTable() . '.visibility', $visibilities);
                });
            }
        } else {
            // However, if we are in console mode (exporting), we need a way to avoid people accessing "self" notes.
            // Todo: how to handle this use case properly? Not exporting "self" seems silly
            // $builder->where($model->getTable() . 'visibility', '!=', self::VISIBILITY_SELF);
        }
    }
}
