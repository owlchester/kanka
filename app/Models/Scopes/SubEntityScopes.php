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
    /**
     * This call should be adapted in each entity model to add required "with()" statements to the query for performance
     * on the datagrids.
     * @param Builder $query
     * @return Builder
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
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedSelect(Builder $query): Builder
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
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeStandardWith(Builder $query): Builder
    {
        return $query->with('entity', 'entitiy.tags');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithApi(Builder $query): Builder
    {
        $relations = [
            'entity',
            'entity.tags', 'entity.notes', 'entity.events',
            'entity.relationships', 'entity.attributes', 'entity.inventories',
            'entity.assets'
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
