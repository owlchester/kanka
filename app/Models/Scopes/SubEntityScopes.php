<?php

namespace App\Models\Scopes;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait SubEntityScopes
 * @package App\Models\Scopes
 *
 * @method static self|Builder preparedWith()
 * @method static self|Builder recent()
 * @method static self|Builder standardWith()
 * @method static self|Builder withApi()
 */
trait SubEntityScopes
{
    /**
     * This call should be adapted in each entity model to add required "with()" statements to the query for performance
     * on the datagrids.
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with([
            'entity',
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeStandardWith($query)
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
        if ($campaign->boosted(true)) {
            $relations[] = 'entity.header';
            $relations[] = 'entity.image';
        }

        return $query->with($relations);
    }
}
