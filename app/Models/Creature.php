<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocations;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Creature
 *
 * @property Creature[]|Collection $descendants
 * @property ?int $creature_id
 * @property bool|int $is_extinct
 * @property bool|int $is_dead
 */
class Creature extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocations;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'name',
        'campaign_id',
        'is_private',
        'creature_id',
        'is_extinct',
        'is_dead',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'creature';

    protected array $sortableColumns = [
        'is_extinct',
        'is_dead',
    ];

    protected string $locationPivot = 'creature_location';

    protected string $locationPivotKey = 'creature_id';

    protected array $sortable = [
        'name',
        'parent.name',
        'is_extinct',
        'is_dead',
        'type',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'creature_id',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'pivotLocations',
    ];

    protected array $exportFields = [
        'base',
        'is_extinct',
        'is_dead',
    ];

    protected array $exploreGridFields = ['is_extinct', 'is_dead'];

    protected array $sanitizable = [
        'name',
    ];

    /**
     * @return string
     */
    public function getParentKeyName()
    {
        return 'creature_id';
    }

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query->with([
            'locations' => function ($sub) {
                $sub->select('id');
            },
        ]));
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['creature_id', 'is_extinct', 'is_dead'];
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.creature');
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'creature_id',
            'location_id',
            'is_extinct',
            'is_dead',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CreatureLocation, $this>
     */
    public function pivotLocations(): HasMany
    {
        return $this->hasMany('App\Models\CreatureLocation');
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if ($this->locations->isNotEmpty()) {
            return true;
        }

        return parent::showProfileInfo();
    }

    /**
     * Determine if the model is extinct.
     */
    public function isExtinct(): bool
    {
        return (bool) $this->is_extinct;
    }

    /**
     * Determine if the model is dead.
     */
    public function isDead(): bool
    {
        return (bool) $this->is_dead;
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        // Pivot tables can be deleted directly
        $this->locations()->detach();
    }
}
