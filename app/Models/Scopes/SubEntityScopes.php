<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait SubEntityScopes
 * @package App\Models\Scopes
 *
 * @method static self|Builder preparedWith()
 * @method static self|Builder preparedSelect()
 * @method static self|Builder preparedGrid()
 * @method static self|Builder recent()
 * @method static self|Builder withApi()
 */
trait SubEntityScopes
{
    protected bool $hasJoinedEntity = false;

    /**
     * This call should be adapted in each entity model to add required "with()" statements to the query for performance
     * on the datagrids.
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity', 'entity.image', 'entity.entityType'
        ])->has('entity');
    }

    /**
     * The grid view shows the same kind of info all the time so it can be simplified
     */
    public function scopePreparedGrid(Builder $query): Builder
    {
        return $query
            ->select($this->exploreGridSelectFields())
            ->with($this->exploreGridWith())
            ->has('entity');
    }

    protected function exploreGridSelectFields(): array
    {
        $extra = [];
        if (property_exists($this, 'exploreGridFields')) {
            $extra = $this->exploreGridFields;
        }
        $defaultFields = array_merge($extra, ['id', 'name', 'type', 'is_private']);
        $tableName = $this->getTable();
        $prefixedFields = [];
        foreach ($defaultFields as $field) {
            $prefixedFields[] = $tableName . '.' . $field;
        }
        return $prefixedFields;
    }

    protected function exploreGridWith(): array
    {
        $with = [
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'type', 'image_path', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'entity.entityType' => function ($sub) {
                $sub->select('id', 'code');
            },
        ];
        if (method_exists($this, 'getParentKeyName')) {
            $with[] = 'children';
        }

        return $with;
    }

    /**
     * Build the list of fields selected in the database for the datagrids.
     * We do it this way to avoid loading `entry` and other fields that end up being
     * useless for the datagrid, since we aren't displaying those fields. By not loading
     * entry, we allow the db to send PHP a lot less data.
     *
     * This function builds a default list of fields available on all models, and each model
     * can add extra fields in the datagridSelectFields() method declared on the models.
     */
    public function scopePreparedSelect(Builder $query): Builder
    {
        if (!method_exists($this, 'datagridSelectFields')) {
            return $query;
        }
        $defaults = ['id', 'name', 'type', 'is_private'];
        $fields = array_merge($defaults, $this->datagridSelectFields());

        $tableName = $this->getTable();
        $prefixedFields = [];
        foreach ($fields as $field) {
            $prefixedFields[] = $tableName . '.' . $field;
        }
        return $query->select($prefixedFields);
    }

    /**
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('updated_at', 'desc');
    }


    /**
     */
    public function scopeWithApi(Builder $query): Builder
    {
        $relations = [
            'entity',
            'entity.image',
            'entity.header',
            'entity.entityType',
            'entity.tags',
            'entity.posts', 'entity.posts.permissions',
            'entity.events',
            'entity.relationships', 'entity.attributes', 'entity.inventories', 'entity.inventories',
            'entity.assets',
            'entity.abilities',
        ];

        if (method_exists($this, 'ancestors')) {
            $relations[] = 'ancestors';
            $relations[] = 'children';
        }
        $with = !empty($this->apiWith) ? $this->apiWith : [];
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
