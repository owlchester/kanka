<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
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
 * @package App\Models
 * @property int|null $ability_id
 * @property mixed|null $charges
 * @property Ability|null $ability
 * @property Collection|Ability[] $descendants
 * @property Collection|Ability[] $abilities
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
    use HasEntry;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'campaign_id',
        'name',
        'slug',
        'type',
        'entry',
        'ability_id',
        'is_private',
        'charges'
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
        'ability_id',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'ability';

    protected array $exportFields = [
        'base',
        'charges'
    ];

    /**
     * Parent ID used for the Node Trait
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
            'abilities' => function ($sub) {
                $sub->select('id', 'name', 'ability_id');
            },
            'children' => function ($sub) {
                $sub->select('id', 'ability_id');
            },
            'entities' => function ($sub) {
                $sub->select('entities.id');
            }
        ]);
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['ability_id'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ability()
    {
        return $this->belongsTo('App\Models\Ability', 'ability_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function abilities()
    {
        return $this->hasMany('App\Models\Ability', 'ability_id', 'id');
    }

    public function entities()
    {
        return $this
            ->belongsToMany(Entity::class, 'entity_abilities')
            ->withPivot('visibility_id');
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
     */
    public function entryWithAttributes()
    {
        return Mentions::map($this);
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
        return (bool) ($this->type || $this->charges);
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'ability_id',
        ];
    }
}
