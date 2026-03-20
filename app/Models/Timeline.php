<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Timeline
 *
 * @property TimelineEra[]|Collection $eras
 * @property int|bool $revert_order
 */
class Timeline extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    public $fillable = [
        'campaign_id',
        'name',
        'calendar_id',
        'is_private',
    ];

    protected array $sortable = [
        'name',
        'type',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'calendar_id',
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

    protected array $apiWith = [
        'eras',
        'eras.elements',
    ];

    /**
     * @return BelongsTo<Calendar, $this>
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo('App\Models\Calendar', 'calendar_id', 'id');
    }

    /**
     * @return HasMany<TimelineEra, $this>
     */
    public function eras(): HasMany
    {
        return $this->hasMany('App\Models\TimelineEra');
    }

    /**
     * @return HasMany<TimelineElement, $this>
     */
    public function elements(): HasMany
    {
        return $this->hasMany(
            'App\Models\TimelineElement',
        );
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
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'calendar_id',
        ];
    }
}
