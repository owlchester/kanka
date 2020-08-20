<?php


namespace App\Models;


use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property TimelineEra[] $eras
 * @property bool $revert_order
 */
class Timeline extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        ExportableTrait,
        SimpleSortableTrait,
        SoftDeletes;

    public $fillable = [
        'name',
        'type',
        'calendar_id',
        'slug',
        'entry',
        'is_private',
        'image',
        'revert_order',
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
        'name',
        'type',
        'calendar_id',
        'is_private',
        'tags',
        'has_image',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'calendar.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'calendar_id',
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
            'calendar',
            'calendar.entity',
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
     *
     */
    public function eras()
    {
        return $this->hasMany('App\Models\TimelineEra');
    }

    /**
     * @return array
     */
    public function menuItems($items = [])
    {
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
