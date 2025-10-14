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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Ability
 *
 * @property ?int $ability_id
 * @property mixed|null $charges
 * @property ?Ability $parent
 * @property Collection|Ability[] $descendants
 * @property Ability[] $orderedAbilities
 * @property Collection|Entity[] $entities
 *
 * @method static self|Builder ordered()
 */
class Ability extends MiscModel
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

    protected $fillable = [
        'campaign_id',
        'name',
        'ability_id',
        'is_private',
        'charges',
    ];

    protected array $sortable = [
        'name',
        'type',
        'parent.name',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'ability_id',
    ];

    protected array $exportFields = [
        'base',
        'charges',
    ];

    protected array $sanitizable = [
        'name',
        'charges',
    ];

    /**
     * Parent ID used for the Node Trait
     *
     * @return string
     */
    public function getParentKeyName()
    {
        return 'ability_id';
    }

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query)
            ->withCount('entities');
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['ability_id'];
    }

    public function entities()
    {
        return $this
            ->belongsToMany(Entity::class, 'entity_abilities')
            ->withPivot(['visibility_id', 'id']);
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        $this->entities()->detach();
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.ability');
    }

    /**
     * Attach an entity to the ability
     */
    public function attachEntity(array $request): int
    {
        $entityIds = Arr::get($request, 'entities');
        $count = 0;
        $visibility = Arr::get($request, 'visibility_id', \App\Enums\Visibility::All);
        $sync = [];

        foreach ($entityIds as $entity) {
            $sync[$entity] = ['visibility_id' => $visibility];
            $count++;
        }
        $this->entities()->syncWithoutDetaching($sync);

        return $count;
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if (! empty($this->charges)) {
            return true;
        }

        return parent::showProfileInfo();
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'ability_id',
        ];
    }
}
