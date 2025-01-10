<?php

namespace App\Models\Scopes;

use App\Facades\CampaignLocalization;
use App\Facades\Permissions;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\Post;
use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Enums\Visibility;
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
            if (!$withInvisible) {
                // Sends the default scope
                return $builder;
            }

            // @phpstan-ignore-next-link
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Our main logic for this scope: filtering on elements the user has access to.
     * @return Builder|void
     */
    public function apply(Builder $query, Model $model)
    {
        // No permission engine on console for the time being. In the future, we might want
        // to build a system to limit exposing private stuff on a campaign export.
        if (app()->runningInConsole() && (!app()->environment('testing') || config('app.skip_permissions') === true)) {
            return $query;
        }

        // For posts, we need a different hook because they can be private even for an admin
        if ($model instanceof Post) {
            return $this->applyToPost($query, $model);
        }

        // Campaign admins doesn't have any restrictions on base
        Permissions::campaign(CampaignLocalization::getCampaign())
            ->action(CampaignPermission::ACTION_READ);
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
        } elseif ($model instanceof MiscModel) {
            return $this->applyToMisc($query, $model);
        }

        return $query;
    }

    /**
     * Permission scope on an Entity model
     */
    protected function applyToEntity(Builder $query, Model $model): Builder
    {
        Permissions::createTemporaryTable();
        // @phpstan-ignore-next-line
        return $query
            //->leftJoin('tmp_permissions as per', 'entities.id', 'per.id')
            ->private(false)
            ->where(function ($subquery) {
                return $subquery
                    ->where(function ($sub) {
                        if (!request()->filled('_perm_v1')) {
                            return $sub
                                ->whereRaw(DB::raw('EXISTS (SELECT * FROM tmp_permissions as perm WHERE perm.id = entities.id)'))
                                ->orWhereIn('entities.type_id', Permissions::allowedEntityTypes());
                        } else {
                            return $sub
                                ->whereIn('entities.id', Permissions::allowedEntities())
                                ->orWhereIn('entities.type_id', Permissions::allowedEntityTypes());
                        }
                    })
                    ->whereNotIn('entities.id', Permissions::deniedEntities())
                ;
            });
    }

    /**
     * Permission scope on a Misc model
     */
    protected function applyToMisc(Builder $query, MiscModel $model): Builder
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
            return $query->private(false) // @phpstan-ignore-line
                ->whereNotIn($table . '.' . $primaryKey, Permissions::deniedModels())
            ;
        }

        /*if (request()->has('_debug_perm')) {
            return $query
                ->whereIn($table . '.' . $primaryKey, Permissions::allowedModels())
                ->whereNotIn($table . '.' . $primaryKey, [])
                ;
        }*/

        $allowed = Permissions::allowedModels();
        if (count($allowed) > 0) {
            $query->where(function ($sub) use ($table, $primaryKey, $allowed) {
                // Defined by mariadb's `in_predicate_conversion_threshold`
                // See https://bugs.launchpad.net/ubuntu/+source/mariadb-10.3/+bug/1964622
                $max = 999;
                $loops = floor(count($allowed) / $max);
                for ($i = 0; $i <= $loops; $i++) {
                    $slice = array_slice($allowed, $i * $max, $max);
                    $sub->orWhereIn($table . '.' . $primaryKey, $slice);
                }
            });
        }

        $denied = Permissions::deniedModels();
        if (!empty($denied)) {
            $query->whereNotIn($table . '.' . $primaryKey, $denied);
        }

        return $query->private(false); // @phpstan-ignore-line
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
     * @return Builder
     */
    protected function applyToPost(Builder $query, Model $model)
    {
        $campaign = CampaignLocalization::getCampaign();
        $table = $model->getTable();
        // Guest, or not part of the campaign either, just get the all visibility
        if (auth()->guest() || !$campaign->userIsMember()) {
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
