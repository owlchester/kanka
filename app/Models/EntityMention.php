<?php

namespace App\Models;

use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Arr;

/**
 * Class EntityMention
 *
 * @property ?string $mentionable_type
 * @property ?int $mentionable_id
 * @property ?int $entity_id Denormalized parent-entity rollup; set for Entity/Post/TimelineElement/QuestElement owners, null for Campaign owners.
 * @property int $target_id
 * @property Entity $entity
 * @property Post|null $post
 * @property QuestElement|null $questElement
 * @property TimelineElement|null $timelineElement
 * @property ?Entity $target
 * @property Campaign|null $campaign
 * @property-read int|null $post_id Virtual, derived from mentionable_type/mentionable_id.
 * @property-read int|null $timeline_element_id Virtual, derived from mentionable_type/mentionable_id.
 * @property-read int|null $quest_element_id Virtual, derived from mentionable_type/mentionable_id.
 * @property-read int|null $campaign_id Virtual, derived from mentionable_type/mentionable_id.
 *
 * @method static self|Builder filterValid()
 */
class EntityMention extends Model
{
    use SortableTrait;

    public $fillable = [
        'mentionable_type',
        'mentionable_id',
        'entity_id',
        'target_id',
    ];

    protected array $sortable = [
        'name',
    ];

    /**
     * @return MorphTo<Model, $this>
     */
    public function mentionable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo<Entity, $this>
     */
    public function target(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'target_id', 'id');
    }

    /**
     * @return BelongsTo<Entity, $this>
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    /**
     * Only meaningful when isPost() is true, matching existing call-site discipline.
     *
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo('App\Models\Post', 'mentionable_id', 'id');
    }

    /**
     * Only meaningful when isTimelineElement() is true, matching existing call-site discipline.
     *
     * @return BelongsTo<TimelineElement, $this>
     */
    public function timelineElement(): BelongsTo
    {
        return $this->belongsTo('App\Models\TimelineElement', 'mentionable_id', 'id');
    }

    /**
     * Only meaningful when isQuestElement() is true, matching existing call-site discipline.
     *
     * @return BelongsTo<QuestElement, $this>
     */
    public function questElement(): BelongsTo
    {
        return $this->belongsTo('App\Models\QuestElement', 'mentionable_id', 'id');
    }

    /**
     * Only meaningful when isCampaign() is true, matching existing call-site discipline.
     *
     * @return BelongsTo<Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'mentionable_id', 'id');
    }

    public function getPostIdAttribute(): ?int
    {
        return $this->mentionable_type === Post::class ? $this->mentionable_id : null;
    }

    public function getTimelineElementIdAttribute(): ?int
    {
        return $this->mentionable_type === TimelineElement::class ? $this->mentionable_id : null;
    }

    public function getQuestElementIdAttribute(): ?int
    {
        return $this->mentionable_type === QuestElement::class ? $this->mentionable_id : null;
    }

    public function getCampaignIdAttribute(): ?int
    {
        return $this->mentionable_type === Campaign::class ? $this->mentionable_id : null;
    }

    /**
     * Determine if the mention goes to a post
     */
    public function isPost(): bool
    {
        return $this->mentionable_type === Post::class;
    }

    /**
     * Determine if the mention goes to an entity.
     *
     * NOTE: intentionally checks entity_id (the rollup column), not mentionable_type.
     * entity_id is also populated for Post/TimelineElement/QuestElement-owned mentions
     * (it's their parent-entity rollup), so this is true for every row returned by
     * Entity::mentions() regardless of true owner — matching pre-refactor behavior
     * relied on by DocumentController::mentions() and the dashboard widget preview.
     */
    public function isEntity(): bool
    {
        return ! empty($this->entity_id);
    }

    /**
     * Determine if the mention goes to a timeline element
     */
    public function isTimelineElement(): bool
    {
        return $this->mentionable_type === TimelineElement::class;
    }

    /**
     * Determine if the mention goes to a quest element
     */
    public function isQuestElement(): bool
    {
        return $this->mentionable_type === QuestElement::class;
    }

    /**
     * Determine if the mention goes to a campaign
     */
    public function isCampaign(): bool
    {
        return $this->mentionable_type === Campaign::class;
    }

    /**
     * Build the query that will loop on the various mentions to get the total count.
     * The AclTrait on entities and posts makes sure only visible things get added to the query.
     */
    public function scopeFilterValid(Builder $query): Builder
    {
        return $query->whereHasMorph(
            'mentionable',
            [Entity::class, Post::class, TimelineElement::class, QuestElement::class, Campaign::class],
            function (Builder $query, string $type) {
                if ($type === Post::class) {
                    $query->has('entity');
                } elseif ($type === TimelineElement::class) {
                    $query->has('timeline.entity');
                } elseif ($type === QuestElement::class) {
                    $query->has('quest.entity');
                }
            }
        );
    }

    public function scopeOnEntity(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', Entity::class);
    }

    public function scopeOnPost(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', Post::class);
    }

    public function scopeOnTimelineElement(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', TimelineElement::class);
    }

    public function scopeOnQuestElement(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', QuestElement::class);
    }

    public function scopeOnCampaign(Builder $query): Builder
    {
        return $query->where('entity_mentions.mentionable_type', Campaign::class);
    }

    public function scopeDatagridElements(Builder $query, array $options): Builder
    {
        $column = Arr::get($options, 'k', 'name');
        $order = Arr::get($options, 'o', 'asc');
        $query->select('entity_mentions.*')
            ->leftJoin('entities as e', 'e.id', 'entity_mentions.entity_id');

        if ($column == 'name') {
            $query->orderByRaw('CASE WHEN e.name IS NULL THEN 1 ELSE 0 END');
            $query->orderBy('e.name', $order);
        } elseif ($column == 'type') {
            $query->orderByRaw('CASE WHEN e.type_id IS NULL THEN 1 ELSE 0 END');
            $query->orderBy('e.type_id', $order);
        }

        return $query
            ->orderBy('entity_mentions.id');
    }

    /**
     * Determine if the mention is linked to an entity.
     * In theory, this is true for everything except a campaign mention, but in practice it's more complicated.
     */
    public function hasEntity(): bool
    {
        return ! empty($this->entity_id) && ! empty($this->entity);
    }

    public function exportFields(): array
    {
        return [
            'entity_id',
            'campaign_id',
            'post_id',
            'timeline_element_id',
            'quest_element_id',
            'target_id',
        ];
    }
}
