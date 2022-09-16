<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Race
 * @package App\Models
 *
 * @property Race[] $descendants
 *
 * @property int $race_id
 * @property Race $race
 * @property Race[] $races
 * @property Location $location
 * @property Location[] $locations
 */
class Race extends MiscModel
{
    use CampaignTrait,
        ExportableTrait,
        Nested,
        SoftDeletes,
        Acl,
        SortableTrait
    ;

    /** @var string[]  */
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
     * Entity type
     * @var string
     */
    protected $entityType = 'race';

    protected $sortableColumns = [
        'race.name',
    ];

    protected $sortable = [
        'name',
        'type',
        'race.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'race_id',
    ];

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'race_id';
    }


    /**
     * Specify parent id attribute mutator
     * @param $value
     * @throws \Exception
     */
    public function setRaceIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith(Builder $query)
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_uuid');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext');
            },
            'races' => function ($sub) {
                $sub->select('id', 'name', 'race_id');
            },
            'locations' => function ($sub) {
                $sub->select('locations.id', 'locations.name');
            },
            'characters',
            'descendants'
        ]);
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['race_id'];
    }

    /**
     * Characters belonging to this race
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->belongsToMany('App\Models\Character', 'character_race');
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
     * Get all characters in the location and descendants
     */
    public function allCharacters()
    {
        $raceIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $raceIds[] = $descendant->id;
        };

        return Character
            ::select('characters.*')
            ->distinct('characters.id')
            ->leftJoin('character_race as cr', function ($join) {
                $join->on('cr.character_id', '=', 'characters.id');
            })
            ->whereIn('cr.race_id', $raceIds);
    }

    /**
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $campaign = CampaignLocalization::getCampaign();

        $count = $this->descendants()->count();
        if ($campaign->enabled('races') && $count > 0) {
            $items['second']['races'] = [
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

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'race_id',
            'location_id'
        ];
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations()
    {
        return $this->belongsToMany('App\Models\Location', 'race_location');
    }
    /**
     * Determine if the model has profile data to be displayed
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        if ($this->locations) {
            return true;
        }

        return parent::showProfile();
    }
}
