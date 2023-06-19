<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\Module;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Models\Scopes\TagScopes;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Tag
 * @package App\Models
 *
 * @property string $name
 * @property string $type
 * @property string $colour
 * @property int|null $tag_id
 * @property Tag|null $tag
 * @property Tag[]|Collection $tags
 * @property bool $is_auto_applied
 * @property bool $is_hidden
 *
 * @property Entity[]|Collection $entities
 */
class Tag extends MiscModel
{
    use Acl
    ;
    use CampaignTrait;
    use ExportableTrait;
    use Nested;
    use SoftDeletes;
    use SortableTrait;
    use TagScopes;
    use HasFactory;

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'tag';

    protected $explicitFilters = ['tag_id'];

    protected $sortable = [
        'name',
        'tag.name',
        'type',
        'colour',
        'is_auto_applied',
        'is_hidden',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'tag.name',
        'colour',
        'is_auto_applied',
        'is_hidden',
    ];

    /** @var string[]  */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'colour',
        'image',
        'entry',
        'tag_id',
        'campaign_id',
        'is_private',
        'is_auto_applied',
        'is_hidden',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'tag_id',
    ];

    /**
     * Parent
     */
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id', 'id');
    }

    /**
     * Children
     */
    public function tags()
    {
        return $this->hasMany('App\Models\Tag', 'tag_id', 'id');
    }
    public function children()
    {
        return $this->tags();
    }

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'tag_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param int $value
     * @throws \Exception
     */
    public function setTagIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
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
            'tag' => function ($sub) {
                $sub->select('id', 'name');
            },
            'tag.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'tags' => function ($sub) {
                $sub->select('id', 'tag_id', 'name');
            },
            'descendants' => function ($sub) {
                $sub->select('id', 'tag_id');
            },
            'descendants.entities' => function ($sub) {
                $sub->select('entities.id', 'entities.name', 'entities.entity_id', 'entities.type_id');
            },
            'entities',
            'children' => function ($sub) {
                $sub->select('id', 'tag_id');
            }
        ]);
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['tag_id', 'colour', 'is_auto_applied','is_hidden'];
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        /** @var Tag $child */
        foreach ($this->allChildren(true)->get() as $child) {
            $child->tags()->detach($this->id);
//            if (!empty($child->child)) {
//                $child->child->tag_id = null;
//                $child->child->save();
//            }
        }
        return parent::detach();
    }

    /**
     * Get all the children
     * @param bool $withTags
     * @return Builder
     */
    public function allChildren(bool $withTags = false)
    {
        $children = [];
        foreach ($this->entities->pluck('id')->toArray() as $entity) {
            $children[] = $entity;
        }
        foreach ($this->descendants as $desc) {
            foreach ($desc->entities()->pluck('entities.id')->toArray() as $entity) {
                $children[] = $entity;
            }
        }

        if ($withTags) {
            return Entity::whereIn('id', $children);
        }
        return Entity::whereIn('id', $children)
            ->whereNotIn('type_id', [config('entities.ids.tag')]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function entities()
    {
        return $this->hasManyThrough(
            'App\Models\Entity',
            'App\Models\EntityTag',
            'tag_id',
            'id',
            'id',
            'entity_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entityTags()
    {
        return $this->hasMany(EntityTag::class);
    }

    /**
     * @param array $items
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $campaign = CampaignLocalization::getCampaign();

        $count = $this->descendants->count();
        if ($count > 0) {
            $items['second']['tags'] = [
                'name' => Module::plural($this->entityTypeId(), 'entities.tags'),
                'route' => 'tags.tags',
                'count' => $count
            ];
        }
        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.tag');
    }

    /**
     * Get the tag's colour class
     * @return string colour css class
     */
    public function colourClass(): string
    {
        if (!$this->hasColour()) {
            return 'color-white !border-0';
        }

        $mappings = config('colours.mappings');
        $colour = $this->colour;
        if (isset($mappings[$this->colour])) {
            $colour = $mappings[$this->colour];
        }

        return 'bg-' . $colour . ' color-palette color-tag !border-0 ';
    }

    /**
     * @return bool
     */
    public function hasColour()
    {
        return !empty($this->colour);
    }

    /**
     * Attach an entity to the tag
     * @param array $request
     * @return bool
     */
    public function attachEntity(array $request): bool
    {
        $entityId = Arr::get($request, 'entity_id');
        $entity = Entity::with('tags')->findOrFail($entityId);

        // Make sure the tag isn't already attached to the entity
        foreach ($entity->entityTags as $tag) {
            if ($tag->tag_id == $this->id) {
                return true;
            }
        }

        $entityTag = EntityTag::create([
            'tag_id' => $this->id,
            'entity_id' => $entityId
        ]);

        return $entityTag !== false;
    }

    /**
     * Get the tag's html
     * @return string
     */
    public function html(): string
    {
        return '<span class="badge ' . ($this->hasColour() ? $this->colourClass() . 'py-1 rounded-sm': 'color-tag rounded-sm px-2 py-1') . '">'
            . e($this->name) . '</span>';
    }

    /**
     * @return string
     */
    public function bubble(): string
    {
        return '<span class="badge ' .
            ($this->hasColour() ? $this->colourClass() : 'color-tag') . '" title="' .
            e($this->name) . '">' . ucfirst(mb_substr($this->slug, 0, 1)) . '</span>';
    }

    /**
     * Determine if the model has profile data to be displayed
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        return (bool) ($this->type || $this->colour);
    }

    /**
     * Determine if the model is a tag that has to be applied to all newly created entities
     * @return bool
     */
    public function isAutoApplied(): bool
    {
        return (bool) $this->is_auto_applied;
    }

    /**
     * Determine if the model is a tag that is hidden
     * @return bool
     */
    public function isHidden(): bool
    {
        return (bool) $this->is_hidden;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'colour',
            'is_auto_applied',
            'is_hidden',
        ];
    }
}
