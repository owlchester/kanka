<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * @property TimelineEra[]|Collection $eras
 * @property int|null $timeline_id
 * @property Timeline[]|Collection $descendants
 */
class Timeline extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasEntry;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    public $fillable = [
        'campaign_id',
        'name',
        'type',
        'calendar_id',
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

    protected array $sanitizable = [
        'name',
        'type',
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

    public function calendar(): BelongsTo
    {
        return $this->belongsTo('App\Models\Calendar', 'calendar_id', 'id');
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
