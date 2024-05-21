<?php

namespace App\Models;

use App\Facades\Module;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

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
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
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
        'timeline_id',
    ];

    protected array $sortable = [
        'name',
        'type',
        'parent.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'calendar_id',
        'timeline_id',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'eras',
        'elements',
    ];

    protected array $exportFields = [
        'base',
        'calendar_id',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'timeline';

    protected array $apiWith = [
        'eras',
        'eras.elements',
    ];

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_path', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'parent' => function ($sub) {
                $sub->select('id', 'name');
            },
            'parent.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
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

    public function timelines(): HasMany
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

    public function eras(): HasMany
    {
        return $this->hasMany('App\Models\TimelineEra');
    }

    public function elements(): HasMany
    {
        return $this->hasMany(
            'App\Models\TimelineElement',
        );
    }

    /**
     * @return string
     */
    public function getParentKeyName()
    {
        return 'timeline_id';
    }

    /**
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
