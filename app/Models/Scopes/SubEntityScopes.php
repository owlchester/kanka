<?php

namespace App\Models\Scopes;

use App\Models\Entity;
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
        return $query->orderBy(
            Entity::query()
                ->select('entities.updated_at')
                ->whereColumn('entities.entity_id', $this->qualifyColumn('id'))
                ->where('entities.type_id', $this->entityTypeId()),
            'desc',
        );
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
        $relations = array_merge($relations, $this->apiRelations());

        return $query
            ->select($this->getTable() . '.*')
            ->has('entity')
            ->with($relations);
    }

    public function apiRelations(): array
    {
        return $this->apiWith ?? [];
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
