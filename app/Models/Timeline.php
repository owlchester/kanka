<?php


namespace App\Models;


use App\Models\Concerns\Nested;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property TimelineEra[] $eras
 * @property bool $revert_order
 * @property int $timeline_id
 * @property Timeline $timeline
 * @property Timeline[] $timelines
 * @property Timeline[] $descendants
 */
class Timeline extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        ExportableTrait,
        SimpleSortableTrait,
        SoftDeletes,
        Nested;

    public $fillable = [
        'name',
        'type',
        'calendar_id',
        'slug',
        'entry',
        'is_private',
        'image',
        'revert_order',
        'timeline_id',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'entry'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'calendar_id',
        'timeline_id',
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
     * @var array
     */
    public $nullableForeignKeys = [
        'calendar_id',
        'timeline_id',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'timeline';


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
            'calendar',
            'calendar.entity',
            'eras',
        ]);
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
     * @return string
     */
    public function getParentIdName()
    {
        return 'timeline_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param $value
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
            'name' => 'timelines.fields.timelines',
            'route' => 'timelines.timelines',
            'count' => $this->descendants()->count()
        ];

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
}
