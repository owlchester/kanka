<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Models\Scopes\TagScopes;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Tag
 *
 * @property string $name
 * @property string $type
 * @property string $colour
 * @property ?string $icon
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
    use HasSlug;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;
    use TagScopes;

    protected array $sortable = [
        'name',
        'colour',
        'icon',
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
        'icon',
    ];

    protected $fillable = [
        'name',
        'slug',
        'colour',
        'icon',
        'campaign_id',
        'is_private',
        'is_auto_applied',
        'is_hidden',
    ];

    protected array $sanitizable = [
        'name',
        'colour',
        'icon',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
    ];

    protected array $exportFields = [
        'base',
        'colour',
        'icon',
        'is_auto_applied',
        'is_hidden',
    ];

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        /** @var Entity $child */
        foreach ($this->allChildren()->get() as $child) {
            $child->tags()->detach($this->id);
        }
    }

    /**
     * Get all the children
     */
    public function allChildren(): Builder
    {
        $descendantIds = $this->entity->descendants()->pluck('entity_id');

        return Entity::whereIn('id', function ($query) use ($descendantIds) {
            $query->select('entity_id')
                ->from('entity_tags')
                ->whereIn('tag_id', $descendantIds->push($this->id));
        });
    }

    /**
     * @return BelongsToMany<Entity, $this>
     */
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

    /**
     * @return HasMany<EntityTag, $this>
     */
    public function entityTags(): HasMany
    {
        return $this->hasMany(EntityTag::class);
    }

    /**
     * @return BelongsToMany<Post, $this>
     */
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

    /**
     * @return HasMany<PostTag, $this>
     */
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
     * Strip '#' when setting colour
     */
    public function setColourAttribute(?string $colour): void
    {
        $this->attributes['colour'] = mb_ltrim($colour ?? '', '#');
    }

    /**
     * Prepend '#' when getting colour
     */
    public function getColourAttribute(): string
    {
        if (empty($this->attributes['colour'])) {
            return '';
        }

        return '#' . $this->attributes['colour'];
    }

    /**
     * Get the tag's structural colour classes
     */
    public function colourClass(): string
    {
        if (! $this->hasColour()) {
            return 'border-0!';
        }

        return 'color-palette color-tag border-0!';
    }

    /**
     * Get inline CSS style for the tag's colour
     */
    public function colourStyle(): string
    {
        if (! $this->hasColour()) {
            return '';
        }

        $hex = $this->colour;
        $textColour = $this->isLightColour($hex) ? '#000' : '#fff';

        return 'background-color: ' . e($hex) . '; color: ' . $textColour . ';';
    }

    /**
     * Determine if a hex colour is light based on luminance
     */
    protected function isLightColour(string $hex): bool
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) !== 6) {
            return false;
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Relative luminance formula
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $luminance > 0.5;
    }

    public function hasColour(): bool
    {
        return ! empty($this->attributes['colour']);
    }

    public function hasIcon(): bool
    {
        return ! empty($this->icon);
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
        if ($this->hasColour() || $this->hasIcon()) {
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

    public function shortname(): string
    {
        return grapheme_extract($this->name, 1);
    }
}
