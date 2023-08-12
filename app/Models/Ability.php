<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\Mentions;
use App\Facades\Module;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;

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
    use CampaignTrait;
    use ExportableTrait;
    use HasFactory;
    use Nested;
    use SoftDeletes;
    use SortableTrait
    ;

    /** @var string[]  */
    protected $fillable = [
        'campaign_id',
        'name',
        'slug',
        'type',
        'entry',
        'image',
        'ability_id',
        'is_private',
        'charges'
    ];

    protected $sortable = [
        'name',
        'type',
        'ability.name',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'ability.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'ability_id',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'ability';

    /**
     * Parent ID used for the Node Trait
     * @return string
     */
    public function getParentIdName()
    {
        return 'ability_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param int $value
     */
    public function setAbilityIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

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
            'ability' => function ($sub) {
                $sub->select('id', 'name');
            },
            'ability.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'abilities' => function ($sub) {
                $sub->select('id', 'name', 'ability_id');
            },
            'children' => function ($sub) {
                $sub->select('id', 'ability_id');
            }
        ]);
    }

    /**
     * Only select used fields in datagrids
     * @return array
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
    public function detach()
    {
        foreach ($this->abilities as $child) {
            $child->ability_id = null;
            $child->save();
        }

        return parent::detach();
    }

    /**
     * Menu items for the entity
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $items['second']['abilities'] = [
            'name' => Module::plural($this->entityTypeId(), 'entities.abilities'),
            'route' => 'abilities.abilities',
            'count' => $this->descendants()->count()
        ];
        $items['second']['entities'] = [
            'name' => 'abilities.show.tabs.entities',
            'route' => 'abilities.entities',
            'count' => $this->entities()->count()
        ];
        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.ability');
    }

    /**
     * @return mixed
     */
    public function entryWithAttributes()
    {
        return Mentions::map($this);
    }

    /**
     * Attach an entity to the tag
     * @param array $request
     * @return bool
     */
    public function attachEntity(array $request): bool
    {
        $entityId = Arr::get($request, 'entity_id');
        $entity = Entity::with('abilities')->findOrFail($entityId);

        // Make sure the tag isn't already attached to the entity
        foreach ($entity->abilities as $ability) {
            if ($ability->ability_id == $this->id) {
                return true;
            }
        }

        $entityAbility = EntityAbility::create([
            'ability_id' => $this->id,
            'entity_id' => $entityId,
            'visibility_id' => Arr::get($request, 'visibility_id', Visibility::VISIBILITY_ALL),
        ]);

        return $entityAbility !== false;
    }

    /**
     * Determine if the model has profile data to be displayed
     * @return bool
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
