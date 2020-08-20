<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\SimpleSortableTrait;
use App\Models\Scopes\TagScopes;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Tag
 * @package App\Models
 *
 * @property string $colour
 */
class Tag extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        NodeTrait,
        ExportableTrait,
        TagScopes,
        SimpleSortableTrait,
        SoftDeletes;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = [
        'name',
        'type',
        'entry',
        'colour'
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'tag';

    protected $explicitFilters = ['tag_id'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'tag_id',
        'is_private',
        'colour',
        'has_image',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'tag.name',
        'colour',
    ];

    /**
     * @var array
     */
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
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
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

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'tag_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param $value
     * @throws \Exception
     */
    public function setTagIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
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
     * @return array
     */
    public function allChildren($withTags = false)
    {
        $children = [];
        foreach ($this->entities()->pluck('entities.id')->toArray() as $entity) {
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
        return Entity::whereIn('id', $children)->whereNotIn('type', ['tag']);
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
    public function menuItems($items = [])
    {
        $campaign = CampaignLocalization::getCampaign();

        $count = $this->descendants->count();
        if ($count > 0) {
            $items['tags'] = [
                'name' => 'tags.show.tabs.tags',
                'route' => 'tags.tags',
                'count' => $count
            ];
        }
        $count = $this->allChildren()->count();
        if ($campaign->enabled('characters')) {
            $items['children'] = [
                'name' => 'tags.show.tabs.children',
                'route' => 'tags.children',
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
    public function colourClass()
    {
        if (!$this->hasColour()) {
            return 'color-white';
        }

        $mappings = config('colours.mappings');
        $colour = $this->colour;
        if (isset($mappings[$this->colour])) {
            $colour = $mappings[$this->colour];
        }

        return 'bg-' . $colour .  ' color-palette color-tag';
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
        return '<span class="label ' . ($this->hasColour() ? $this->colourClass() : 'label-default') . '">'
            . e($this->name) . '</span>';
    }

    public function bubble(): string
    {
        return '<span class="label label-tag-bubble ' . ($this->hasColour() ? $this->colourClass() : 'label-default') . '" title="'
            . e($this->name) . '">' . ucfirst(substr(e($this->name), 0, 1)) . '</span>';
    }
}
