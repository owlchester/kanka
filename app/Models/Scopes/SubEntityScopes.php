<?php

namespace App\Models\Scopes;

use App\Facades\CampaignLocalization;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait SubEntityScopes
 * @package App\Models\Scopes
 *
 * @method static self|Builder preparedWith()
 * @method static self|Builder preparedSelect()
 * @method static self|Builder recent()
 * @method static self|Builder standardWith()
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
            'entity',
        ])->has('entity');
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
    public function scopeStandardWith(Builder $query): Builder
    {
        return $query->with('entity', 'entitiy.tags');
    }

    /**
     */
    public function scopeWithApi(Builder $query): Builder
    {
        $relations = [
            'entity',
            'entity.tags', 'entity.posts', 'entity.events',
            'entity.relationships', 'entity.attributes', 'entity.inventories',
            'entity.assets'
        ];

        $with = !empty($this->apiWith) ? $this->apiWith : [];
        foreach ($with as $relation) {
            $relations[] = $relation;
        }

        $campaign = CampaignLocalization::getCampaign();
        if ($campaign && $campaign->superboosted()) {
            $relations[] = 'entity.header';
            $relations[] = 'entity.image';
        }

        return $query->has('entity')->with($relations);
    }

    public function scopeJoinEntity(Builder $query): Builder
    {
        if ($this->hasJoinedEntity) {
            return $query;
        }

        $this->hasJoinedEntity = true;

        return $query
            ->distinct()
            ->leftJoin('entities as e', function ($join) {
                $join->on('e.entity_id', '=', $this->getTable() . '.id');
                // @phpstan-ignore-next-line
                $join->where('e.type_id', '=', $this->entityTypeID())
                    ->whereRaw('e.campaign_id = ' . $this->getTable() . '.campaign_id');
            })
            ->groupBy($this->getTable() . '.id');
    }
}
