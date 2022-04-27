<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Race
 * @package App\Models
 *
 * @property Race[] $descendants
 *
 * @property int $race_id
 * @property Race $race
 * @property Race[] $races
 */
class Race extends MiscModel
{
    use CampaignTrait,
        ExportableTrait,
        Nested,
        SimpleSortableTrait,
        SoftDeletes,
        Acl
    ;

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
        'race_id',
    ];

    protected $sortableColumns = [
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
    public function scopePreparedWith($query)
    {
        return $query->with([
            'entity',
            'entity.image',
            'races',
            'characters',
        ]);
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
    public function allCharacters(bool $allMembers = false)
    {
        $raceIds = [$this->id];
        if ($allMembers) {
            foreach ($this->descendants as $descendant) {
                $raceIds[] = $descendant->id;
            };
        }

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

        $count = $this->races()->count();
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
}
