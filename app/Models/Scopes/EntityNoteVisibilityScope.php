<?php

namespace App\Models\Scopes;

use App\Facades\CampaignLocalization;
use App\Facades\Permissions;
use App\Models\Visibility;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EntityNoteVisibilityScope implements Scope
{
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
            return $builder->where(
                $model->getTable() . '.visibility',
                Visibility::VISIBILITY_ALL_STR
            );
        }

        Permissions::user(auth()->user())
            ->campaign(CampaignLocalization::getCampaign());

        // Either mine (self && created_by = me) or (if admin: !self, else: all)
        $table = $model->getTable();
        $builder->where(function ($sub) use ($table) {
            $visibilities = auth()->user()->isAdmin()
                ? [
                    Visibility::VISIBILITY_ALL_STR, Visibility::VISIBILITY_ADMIN_STR,
                    Visibility::VISIBILITY_ADMIN_SELF_STR, Visibility::VISIBILITY_MEMBERS_STR
                ]
                : [Visibility::VISIBILITY_ALL_STR, Visibility::VISIBILITY_MEMBERS_STR];
            $sub
                ->where(function ($self) use ($table) {
                    $self
                        ->whereIn($table . '.visibility', [
                            Visibility::VISIBILITY_SELF_STR,
                            Visibility::VISIBILITY_ADMIN_SELF_STR,
                        ])
                        ->where($table . '.created_by', auth()->user()->id);
                })
                ->orWhereIn($table . '.visibility', $visibilities)
                ->orWhereIn($table . '.id', Permissions::allowedPosts());
            })
            ->whereNotIn($table . '.id', Permissions::deniedPosts());

        return $builder;
    }
}
