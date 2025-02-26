<?php

namespace App\Models;

use App\Facades\TimelineElementCache;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasSuggestions;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Sanitizable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * Class TimelineElement
 * @package App\Models
 *
 * @property int $id
 * @property int $timeline_id
 * @property int $era_id
 * @property ?int $entity_id
 * @property string $name
 * @property string $date
 * @property int $position
 * @property string $colour
 * @property string $icon
 * @property bool|int $use_entity_entry
 * @property bool|int $is_collapsed
 * @property bool|int $use_event_date
 *
 * @property Timeline $timeline
 * @property TimelineEra $era
 * @property Entity $entity
 *
 * @method static self|Builder ordered()
 */
class TimelineElement extends Model
{
    use Blameable;
    use HasEntry;
    use HasFactory;
    use HasSuggestions;
    use HasVisibility;
    use Sanitizable;
    use Searchable;

    protected $fillable = [
        'timeline_id',
        'era_id',
        'entity_id',
        'name',
        'entry',
        'position',
        'colour',
        'visibility_id',
        'icon',
        'date',
        'is_collapsed',
        'use_entity_entry',
        'use_event_date',
    ];

    public $casts = [
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected array $suggestions = [
        TimelineElementCache::class => 'clearSuggestion',
    ];

    protected array $sanitizable = [
        'name',
        'date',
        'icon'
    ];

    public function timeline(): BelongsTo
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    public function era(): BelongsTo
    {
        return $this->belongsTo(TimelineEra::class, 'era_id');
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    /**
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->with('entity')
            ->orderBy('position');
    }

    /**
     */
    public function elementName(): string
    {
        if (!empty($this->entity_id)) {
            return $this->entity?->name ?? __('crud.history.unknown');
        }
        return $this->name;
    }

    public function mentionName(): string
    {
        if (!empty($this->name)) {
            return strip_tags(htmlentities($this->name));
        }

        // @phpstan-ignore-next-line
        return strip_tags($this->entity?->name);
    }

    /**
     * For legacy tinymce editor
     */
    public function hasEntity(): bool
    {
        return false;
    }

    public function collapsed(): bool
    {
        return $this->is_collapsed;
    }

    /**
     * Check if the element has an entity, but it's not accessible (permission issue for non-admins)
     */
    public function invisibleEntity(): bool
    {
        if (empty($this->entity_id)) {
            return false;
        }
        return empty($this->entity);
    }

    /**
     */
    public function editingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'entity_user')
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }

    /**
     * List of entities that mention this entity
     */
    public function mentions(): HasMany
    {
        return $this->hasMany('App\Models\EntityMention', 'timeline_element_id', 'id');
    }

    public function visible(): bool
    {
        if (empty($this->entity_id)) {
            return true;
        }
        return $this->entity && !$this->entity->isMissingChild();
    }

    /**
     * Get the value used to index the model.
     *
     */
    public function getScoutKey()
    {
        return $this->getTable() . '_' . $this->id;
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'entities';
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query
            ->select([$this->getTable() . '.*', 'entities.id as entity_id'])
            ->leftJoin('timelines', 'timelines.id', '=', 'timeline_elements.timeline_id')
            ->leftJoin('entities', function ($join) {
                $join->on('entities.entity_id', $this->getTable() . '.id');
            })
            ->has('timeline')
            ->has('timeline.entity')
            ->with(['timeline', 'timeline.entity']);
    }

    public function toSearchableArray()
    {
        return [
            'campaign_id' => $this->timeline->entity->campaign_id,
            'entity_id' => $this->timeline->entity->id,
            'name' => $this->name,
            'type'  => 'timeline_element',
            'entry' => strip_tags($this->entry),
        ];
    }
}
