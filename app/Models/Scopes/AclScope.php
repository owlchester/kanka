<?php

namespace App\Models\Scopes;

use App\Facades\CampaignLocalization;
use App\Facades\Permissions;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\MiscModel;
use App\Models\Visibility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AclScope implements Scope
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
     * Our main logic for this scope: filtering on elements the user has access to.
     * @param Builder $query
     * @param Model $model
     * @return Builder|void
     */
    public function apply(Builder $query, Model $model)
    {
        // No permission engine on console for the time being. In the future, we might want
        // to build a system to limit exposing private stuff on a campaign export.
        if (app()->runningInConsole()) {
            return $query;
        }

        // For posts, we need a different hook because they can be private even for an admin
        if ($model instanceof EntityNote) {
            return $this->applyToPost($query, $model);
        }

        // Campaign admins doesn't have any restrictions on base
        Permissions::campaign(CampaignLocalization::getCampaign())
            ->action(CampaignPermission::ACTION_READ);
        if (auth()->check()) {
            Permissions::user(auth()->user());
        }

        if (Permissions::isAdmin()) {
            // Check if this is a visibility entity or a global kanka entity
            return $query;
        }

        if ($model instanceof Entity) {
            return $this->applyToEntity($query, $model);
        } elseif ($model instanceof MiscModel) {
            return $this->applyToMisc($query, $model);
        }
        dd($model);

        return $query;
    }

    /**
     * Permission scope on an Entity model
     * @param Builder $query
     * @param $model
     * @return Builder
     */
    protected function applyToEntity(Builder $query, Model $model): Builder
    {
        return $query
            ->private(false)
            ->where(function ($subquery) {
                return $subquery
                    ->where(function ($sub) {
                        return $sub->whereIn('entities.id', Permissions::allowedEntities())
                            ->orWhereIn('entities.type_id', Permissions::allowedEntityTypes());
                    })
                    ->whereNotIn('entities.id', Permissions::deniedEntities())
                ;
            });
    }

    /**
     * Permission scope on a Misc model
     * @param Builder $query
     * @param Model $model
     * @return Builder
     */
    protected function applyToMisc(Builder $query, Model $model): Builder
    {
        $table = $model->getTable();
        $primaryKey = 'id';
        $type = $this->entityType($model);

        if (empty($type)) {
            return $query;
        }

        // Limit the scope to reduce the number of queries
        Permissions::entityType($type);

        // If the user has a role which can read all entities, only check on denied elements
        if (Permissions::canRole()) {
            return $query->private(false)
                ->whereNotIn($table . '.' . $primaryKey, Permissions::deniedModels())
            ;
        }

        return $query
            ->whereIn($table . '.' . $primaryKey, Permissions::allowedModels())
            ->whereNotIn($table . '.' . $primaryKey, Permissions::deniedModels())
        ;
    }

    /**
     * Map the misc model to the entity type. Should move this somewhere else?
     * @param MiscModel $model
     * @return string|false
     */
    protected function entityType(MiscModel $model): int
    {
        return config('entities.ids.' . $model->getEntityType());
    }

    /**
     * Apply the ACL scope to posts.
     * @param Builder $query
     * @param Model $model
     * @return Builder
     */
    protected function applyToPost(Builder $query, Model $model)
    {
        $table = $model->getTable();
        if (auth()->guest()) {
            return $query->where($table . '.visibility', Visibility::VISIBILITY_ALL_STR);
        }

        Permissions::campaign(CampaignLocalization::getCampaign());

        // Either mine (self && created_by = me) or (if admin: !self, else: all)
        return $query->where(function ($sub) use ($model, $table) {
            $visibilities = Permissions::isAdmin()
                ? [Visibility::VISIBILITY_ALL_STR, Visibility::VISIBILITY_ADMIN_STR,
                    Visibility::VISIBILITY_ADMIN_SELF_STR, Visibility::VISIBILITY_MEMBERS_STR]
                : [Visibility::VISIBILITY_ALL_STR, Visibility::VISIBILITY_MEMBERS_STR];
            $sub
                ->where(function ($self) use ($model, $table) {
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
    }

}
