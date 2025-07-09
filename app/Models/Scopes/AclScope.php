<?php

namespace App\Models\Scopes;

use App\Enums\Permission;
use App\Enums\Visibility;
use App\Facades\CampaignLocalization;
use App\Facades\Permissions;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

/**
 * @method static self|Builder withInvisible()
 */
class AclScope implements Scope
{
    /**
     * All the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithInvisible'];

    /**
     * Extend the query builder with the needed functions.
     *
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
     * @return void
     */
    protected function addWithInvisible(Builder $builder)
    {
        $builder->macro('withInvisible', function (Builder $builder, $withInvisible = true) {
            if (! $withInvisible) {
                // Sends the default scope
                return $builder;
            }

            // @phpstan-ignore-next-link
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Our main logic for this scope: filtering on elements the user has access to.
     *
     * @return Builder|void
     */
    public function apply(Builder $query, Model $model)
    {
        // No permission engine on console for the time being. In the future, we might want
        // to build a system to limit exposing private stuff on a campaign export.
        if (app()->runningInConsole() && (! app()->environment('testing') || config('app.skip_permissions') === true)) {
            return $query;
        }

        // For posts, we need a different hook because they can be private even for an admin
        if ($model instanceof Post) {
            return $this->applyToPost($query, $model);
        }

        // Campaign admins don't have any restrictions on base
        Permissions::campaign(CampaignLocalization::getCampaign())
            ->action(Permission::View);
        if (auth()->check()) {
            Permissions::user(auth()->user());
        }
        /*if ($model instanceof MiscModel) {
            Permissions::entityTypeID($model->entityTypeId());
        }*/

        if (Permissions::isAdmin()) {
            // Check if this is a visibility entity or a global kanka entity
            return $query;
        }

        if ($model instanceof Entity) {
            return $this->applyToEntity($query, $model);
        }

        return $query;
    }

    /**
     * Permission scope on an Entity model
     */
    protected function applyToEntity(Builder $query, Entity $model): Builder
    {
        if (auth()->check()) {
            Permissions::createTemporaryTable();

            // @phpstan-ignore-next-line
            return $query
                ->private(false)
                ->where(function ($subquery) use ($model) {
                    return $subquery
                        ->where(function ($sub) use ($model) {
                            return $sub
                                ->whereRaw(DB::raw('EXISTS (SELECT * FROM tmp_permissions as perm WHERE perm.id = ' . $model->getTable() . '.id)'))
                                ->orWhereIn($model->getTable() . '.type_id', Permissions::allowedEntityTypes());
                        })
                        ->whereNotIn($model->getTable() . '.id', Permissions::deniedEntities());
                });
        }

        // Unlogged users have a read-only replica db to query, so a left join is needed directly on the permission table
        $publicRoleId = Permissions::publicRoleID();

        // @phpstan-ignore-next-line
        return $query
            ->private(false)
            ->where(function ($subquery) use ($model, $publicRoleId) {
                return $subquery
                    ->where(function ($sub) use ($model, $publicRoleId) {
                        return $sub
                            ->whereRaw(DB::raw('EXISTS (SELECT * FROM campaign_permissions as perm WHERE perm.entity_id = ' . $model->getTable() . '.id AND perm.access = 1 AND perm.campaign_role_id = ' . $publicRoleId . ')'))
                            // ->orWhereIn($model->getTable() . '.id', Permissions::allowedEntities())
                            ->orWhereIn($model->getTable() . '.type_id', Permissions::allowedEntityTypes());
                    })
                    ->whereNotIn($model->getTable() . '.id', Permissions::deniedEntities());
            });
    }

    /**
     * Map the misc model to the entity type. Should move this somewhere else?
     */
    protected function entityType(MiscModel $model): int
    {
        return config('entities.ids.' . $model->getEntityType());
    }

    /**
     * Apply the ACL scope to posts.
     *
     * @return Builder
     */
    protected function applyToPost(Builder $query, Model $model)
    {
        $campaign = CampaignLocalization::getCampaign();
        $table = $model->getTable();
        // Guest, or not part of the campaign either, just get the all visibility
        if (auth()->guest() || ! $campaign->userIsMember()) {
            return $query->where($table . '.visibility_id', Visibility::All);
        }

        Permissions::campaign($campaign);
        Permissions::user(auth()->user());

        // Either mine (self && created_by = me) or (if admin: !self, else: all)
        return $query
            // Ignore the Visibility scope because we're overriding it here with the permission engine of posts
            ->withoutGlobalScope(VisibilityIDScope::class)
            ->where(function ($sub) use ($table) {
                $visibilities = Permissions::isAdmin()
                    ? [Visibility::All, Visibility::Admin,
                        Visibility::AdminSelf, Visibility::Member]
                    : [Visibility::All, Visibility::Member];
                $sub
                    ->where(function ($self) use ($table) {
                        $self
                            ->whereIn($table . '.visibility_id', [
                                Visibility::Self,
                                Visibility::AdminSelf,
                            ])
                            ->where($table . '.created_by', auth()->user()->id);
                    })
                    ->orWhereIn($table . '.visibility_id', $visibilities)
                    ->orWhereIn($table . '.id', Permissions::allowedPosts());
            })
            ->whereNotIn($table . '.id', Permissions::deniedPosts());
    }
}
