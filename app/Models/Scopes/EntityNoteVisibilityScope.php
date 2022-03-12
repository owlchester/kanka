<?php

namespace App\Models\Scopes;

use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Models\EntityNotePermission;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EntityNoteVisibilityScope implements Scope
{
    /**
     * Visibility constants
     */
    const VISIBILITY_ALL = 'all';
    const VISIBILITY_ADMIN = 'admin';
    const VISIBILITY_SELF = 'self';
    const VISIBILITY_MEMBERS = 'members';
    const VISIBILITY_ADMIN_SELF = 'admin-self';

    private $deniedIds = [];
    private $allowedIds = [];
    private $loaded = false;

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
            // $builder->where($model->getTable() . 'visibility', '!=', self::VISIBILITY_SELF);
            return $builder;
        }

        // If we aren't authenticated, just see what is set to all
        if (!auth()->check()) {
            $builder->where($model->getTable() . '.visibility', self::VISIBILITY_ALL);
            return $builder;
        }

        // Either mine (self && created_by = me) or (if admin: !self, else: all)
        $builder->where(function ($sub) use ($model) {
            $visibilities = auth()->user()->isAdmin()
                ? [self::VISIBILITY_ALL, self::VISIBILITY_ADMIN, self::VISIBILITY_ADMIN_SELF, self::VISIBILITY_MEMBERS]
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
                ->orWhereIn($model->getTable() . '.visibility', $visibilities)
                ->orWhereIn($model->getTable() . '.id', $this->allowedIds());
            })
            ->whereNotIn($model->getTable() . '.id', $this->deniedIds());

        return $builder;
    }

    /**
     * @return array
     */
    private function deniedIds(): array
    {
        $this->loadAdvanced();
        return $this->deniedIds;
    }

    /**
     * @return array
     */
    private function allowedIds(): array
    {
        $this->loadAdvanced();
        return $this->allowedIds;
    }

    /**
     *
     */
    private function loadAdvanced()
    {
        if ($this->loaded) {
            return;
        }

        /** @var EntityNotePermission $perm */
        $perms = EntityNotePermission::
            select('entity_note_id')
            ->where('user_id', auth()->user()->id)
            ->get();
        foreach ($perms as $perm) {
            if ($perm->permission === 2) {
                $this->deniedIds[] = $perm->entity_note_id;
            } else {
                $this->allowedIds[] = $perm->entity_note_id;
            }
        }

        // User roles
        $campaign = CampaignLocalization::getCampaign();
        $roles = UserCache::roles()->where('campaign_id', $campaign->id);
        $roleIds = $roles->pluck('id')->toArray();

        $perms = EntityNotePermission::whereIn('role_id', $roleIds)
            ->get();
        foreach ($perms as $perm) {
            if ($perm->permission === 2) {
                $this->deniedIds[] = $perm->entity_note_id;
            } else {
                $this->allowedIds[] = $perm->entity_note_id;
            }
        }



        $this->loaded = true;
    }
}
