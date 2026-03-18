<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait SubEntityScopes
 *
 * @method static self|Builder recent()
 * @method static self|Builder withApi()
 */
trait SubEntityScopes
{
    protected bool $hasJoinedEntity = false;

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeWithApi(Builder $query): Builder
    {
        $relations = [
            'entity',
            'entity.image',
            'entity.header',
            'entity.entityType',
            'entity.tags',
            'entity.posts', 'entity.posts.permissions',
            'entity.reminders',
            'entity.relationships', 'entity.attributes', 'entity.inventories', 'entity.inventories',
            'entity.assets',
            'entity.abilities',
        ];

        if (method_exists($this, 'ancestors')) {
            $relations[] = 'ancestors';
            $relations[] = 'children';
        }
        $with = ! empty($this->apiWith) ? $this->apiWith : [];
        foreach ($with as $relation) {
            $relations[] = $relation;
        }

        return $query
            ->select($this->getTable() . '.*')
            ->has('entity')
            ->with($relations);
    }

    public function scopeJoinEntity(Builder $query): Builder
    {
        if ($this->hasJoinedEntity) {
            return $query;
        }

        $this->hasJoinedEntity = true;

        return $query
            ->leftJoin('entities as e', function ($join) {
                $join->on('e.entity_id', '=', $this->getTable() . '.id');
                // @phpstan-ignore-next-line
                $join->where('e.type_id', '=', $this->entityTypeID())
                    ->whereRaw('e.campaign_id = ' . $this->getTable() . '.campaign_id');
            })
            ->groupBy($this->getTable() . '.id');
    }
}
