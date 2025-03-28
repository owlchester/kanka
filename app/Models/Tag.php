<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Models\Scopes\TagScopes;
use App\Observers\TagObserver;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Tag
 *
 * @property string $name
 * @property string $type
 * @property string $colour
 * @property ?int $tag_id
 * @property bool|int $is_auto_applied
 * @property bool|int $is_hidden
 * @property Entity[]|Collection $entities
 */
class Tag extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use HasSlug;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;
    use TagScopes;

    /**
     * Entity type
     */
    protected string $entityType = 'tag';

    protected array $explicitFilters = ['tag_id'];

    protected array $sortable = [
        'name',
        'parent.name',
        'colour',
        'is_auto_applied',
        'is_hidden',
        'type',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'colour',
        'is_auto_applied',
        'is_hidden',
    ];

    protected $fillable = [
        'name',
        'slug',
        'colour',
        'tag_id',
        'campaign_id',
        'is_private',
        'is_auto_applied',
        'is_hidden',
    ];

    protected array $sanitizable = [
        'name',
        'colour',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'tag_id',
    ];

    protected array $exportFields = [
        'base',
        'colour',
        'is_auto_applied',
        'is_hidden',
    ];

    protected static function booted()
    {
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }
        static::observe(TagObserver::class);
    }

    public function getParentKeyName(): string
    {
        return 'tag_id';
    }

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
        return ['tag_id', 'colour', 'is_auto_applied', 'is_hidden'];
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        /** @var Entity $child */
        foreach ($this->allChildren(true)->get() as $child) {
            $child->tags()->detach($this->id);
            //            if (!empty($child->child)) {
            //                $child->child->tag_id = null;
            //                $child->child->save();
            //            }
        }
    }

    /**
     * Get all the children
     *
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

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(
            'App\Models\Entity',
            'entity_tags',
            'tag_id',
            'entity_id',
            'id',
            'id'
        );
    }

    public function entityTags(): HasMany
    {
        return $this->hasMany(EntityTag::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            'App\Models\Post',
            'post_tag',
            'tag_id',
            'post_id',
            'id',
            'id'
        );
    }

    public function postTags(): HasMany
    {
        return $this->hasMany(PostTag::class);
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.tag');
    }

    /**
     * Get the tag's colour class
     *
     * @return string colour css class
     */
    public function colourClass(): string
    {
        if (! $this->hasColour()) {
            return '!border-0';
        }

        $mappings = config('colours.mappings');
        $colour = $this->colour;
        if (isset($mappings[$this->colour])) {
            $colour = $mappings[$this->colour];
        }
        $text = null;
        if (in_array($colour, ['navy', 'black'])) {
            $text = 'text-white';
        }

        return 'bg-' . $colour . ' color-palette color-tag !border-0 ' . $text . ' ';
    }

    public function hasColour(): bool
    {
        return ! empty($this->colour);
    }

    /**
     * Attach entities to the tag
     */
    public function attachEntities(array $entityIds): int
    {
        $data = $this->entities()->syncWithoutDetaching($entityIds);

        return count($data['attached']);
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if (! empty($this->colour)) {
            return true;
        }

        return parent::showProfileInfo();
    }

    /**
     * Determine if the model is a tag that has to be applied to all newly created entities
     */
    public function isAutoApplied(): bool
    {
        return (bool) $this->is_auto_applied;
    }

    /**
     * Determine if the model is a tag that is hidden
     */
    public function isHidden(): bool
    {
        return (bool) $this->is_hidden;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
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
