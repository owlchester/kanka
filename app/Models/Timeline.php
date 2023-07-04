<?php

namespace App\Models;

use App\Facades\Module;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @property TimelineEra[]|Collection $eras
 * @property int|null $timeline_id
 * @property Timeline|null $timeline
 * @property Timeline[]|Collection $timelines
 * @property Timeline[]|Collection $descendants
 */
class Timeline extends MiscModel
{
    use Acl;
    use CampaignTrait;
    use ExportableTrait;
    use Nested;
    use SoftDeletes;
    use SortableTrait;

    public $fillable = [
        'campaign_id',
        'name',
        'type',
        'calendar_id',
        'slug',
        'entry',
        'is_private',
        'image',
        'timeline_id',
    ];

    protected $sortable = [
        'name',
        'type',
        'timeline.name',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'calendar.name',
        'timeline.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'calendar_id',
        'timeline_id',
    ];

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'eras',
        'elements',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'timeline';

    protected array $apiWith = [
        'eras',
        'eras.elements',
    ];

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'timeline' => function ($sub) {
                $sub->select('id', 'name', 'timeline_id');
            },
            'timeline.entity',
            'eras' => function ($sub) {
                $sub->select('id', 'timeline_id');
            },
            'timelines' => function ($sub) {
                $sub->select('id', 'name', 'timeline_id');
            },
            'children' => function ($sub) {
                $sub->select('id', 'timeline_id');
            }
        ]);
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['timeline_id'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar()
    {
        return $this->belongsTo('App\Models\Calendar', 'calendar_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timelines()
    {
        return $this->hasMany('App\Models\Timeline', 'timeline_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeline()
    {
        return $this->belongsTo('App\Models\Timeline', 'timeline_id', 'id');
    }

    /**
     *
     */
    public function eras()
    {
        return $this->hasMany('App\Models\TimelineEra');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements()
    {
        return $this->hasMany(
            'App\Models\TimelineElement',
        );
    }

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'timeline_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param int|null $value
     */
    public function setTimelineIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $items['second']['timelines'] = [
            'name' => Module::plural($this->entityTypeId(), 'entities.timelines'),
            'route' => 'timelines.timelines',
            'count' => $this->descendants()->count()
        ];
        if (auth()->check() && auth()->user()->can('update', $this)) {
            $items['second']['eras'] = [
                'name' => 'timelines.fields.eras',
                'route' => 'timelines.timeline_eras.index',
                'count' => $this->eras->count()
            ];
            $items['second']['reorder'] = [
                'name' => 'timelines.show.tabs.reorder',
                'route' => 'timelines.reorder',
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
        return (int) config('entities.ids.timeline');
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'calendar_id',
            'timeline_id',
        ];
    }
}
