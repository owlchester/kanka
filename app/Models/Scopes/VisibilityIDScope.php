<?php

namespace App\Models\Scopes;

use App\Enums\Visibility;
use App\Facades\CampaignLocalization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class VisibilityIDScope implements Scope
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
            if (! $withInvisible) {
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
        if (! auth()->check()) {
            $builder->where($model->getTable() . '.visibility_id', Visibility::All);

            return;
        }
        $campaign = CampaignLocalization::getCampaign();
        if (! auth()->user()->can('member', $campaign)) {
            $builder->where($model->getTable() . '.visibility_id', Visibility::All);

            return;
        }

        // Either mine (self && created_by = me) or (if admin: !self, else: all)
        $builder->where(function ($sub) use ($model) {
            $visibilities = auth()->user()->isAdmin()
                ? [Visibility::All, Visibility::Admin,
                    Visibility::AdminSelf, Visibility::Member]
                : [Visibility::All, Visibility::Member];
            $sub
                ->where(function ($self) use ($model) {
                    $self
                        ->whereIn($model->getTable() . '.visibility_id', [
                            Visibility::Self,
                            Visibility::AdminSelf,
                        ])
                        ->where($model->getTable() . '.created_by', auth()->user()->id);
                })
                ->orWhereIn($model->getTable() . '.visibility_id', $visibilities);
        });
    }
}
