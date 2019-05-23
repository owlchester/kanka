<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;

class Race extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'campaign_id',
        'slug',
        'type',
        'image',
        'entry',
        'is_private',
        'race_id',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type', 'entry'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'race';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'race_id',
        'tag_id',
        'is_private',
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'race_id',
    ];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
    use ExportableTrait;

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with(['entity']);
    }

    /**
     * Characters belonging to this race
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany('App\Models\Character', 'race_id', 'id');
    }

    /**
     * Parent Race
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function race()
    {
        return $this->belongsTo('App\Models\Race', 'race_id', 'id');
    }

    /**
     * Children Races
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function races()
    {
        return $this->hasMany('App\Models\Race', 'race_id', 'id');
    }

    /**
     * @return array
     */
    public function menuItems($items = [])
    {
        $campaign = $this->campaign;

        $count = $this->characters()->acl()->count();
        if ($campaign->enabled('characters') && $count > 0) {
            $items['characters'] = [
                'name' => 'races.show.tabs.characters',
                'route' => 'races.characters',
                'count' => $count
            ];
        }
        $count = $this->races()->acl()->count();
        if ($campaign->enabled('races') && $count > 0) {
            $items['races'] = [
                'name' => 'races.show.tabs.races',
                'route' => 'races.races',
                'count' => $count
            ];
        }
        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.race');
    }
}
