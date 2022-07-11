<?php

namespace App\Models\Scopes;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

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
    /**
     * This call should be adapted in each entity model to add required "with()" statements to the query for performance
     * on the datagrids.
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query)
    {
        return $query->with([
            'entity',
        ])->has('entity');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedSelect(Builder $query)
    {
        if (!method_exists($this, 'datagridSelectFields')) {
            return $query;
        }
        $defaults = ['id', 'name', 'type', 'image', 'is_private'];
        $fields = array_merge($defaults, $this->datagridSelectFields());

        $tableName = $this->getTable();
        $prefixedFields = [];
        foreach ($fields as $field) {
            $prefixedFields[] = $tableName . '.' . $field;
        }
        return $query->select($prefixedFields);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeRecent(Builder $query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * @param $Builder query
     * @return Builder
     */
    public function scopeStandardWith(Builder $query)
    {
        return $query->with('entity', 'entitiy.tags');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithApi(Builder $query)
    {
        $relations = [
            'entity',
            'entity.tags', 'entity.notes', 'entity.events',
            'entity.relationships', 'entity.attributes', 'entity.inventories',
            'entity.files', 'entity.links'
        ];

        $with = !empty($this->apiWith) ? $this->apiWith : [];
        foreach ($with as $relation) {
            $relations[] = $relation;
        }

        $campaign = CampaignLocalization::getCampaign();
        if ($campaign->superboosted()) {
            $relations[] = 'entity.header';
            $relations[] = 'entity.image';
        }

        return $query->with($relations);
    }
}
