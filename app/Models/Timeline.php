<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
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
 * Class Timeline
 * @property TimelineEra[]|Collection $eras
 * @property ?int $timeline_id
 * @property int|bool $revert_order
 * @property Timeline[]|Collection $descendants
 */
class Timeline extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
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
        'calendar_id',
        'is_private',
        'timeline_id',
    ];

    protected array $sortable = [
        'name',
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
        return parent::scopePreparedWith($query->with([
            'parent' => function ($sub) {
                $sub->select('id', 'name');
            },
            'parent.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
        ]))->withCount('eras');
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
