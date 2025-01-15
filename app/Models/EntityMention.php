<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

/**
 * Class EntityMention
 * @package App\Models
 *
 * @property int $entity_id
 * @property ?int $post_id
 * @property ?int $quest_element_id
 * @property ?int $timeline_element_id
 * @property ?int $campaign_id
 * @property int $target_id
 * @property Entity $entity
 * @property Post|null $post
 * @property QuestElement|null $questElement
 * @property TimelineElement|null $timelineElement
 * @property ?Entity $target
 * @property Campaign|null $campaign
 *
 * @method static self|Builder filterValid()
 */
class EntityMention extends Model
{
    use SortableTrait;

    public $fillable = [
        'entity_id',
        'post_id',
        'timeline_element_id',
        'quest_element_id',
        'campaign_id',
        'target_id'
    ];

    protected array $sortable = [
        'name',
    ];

    /**
     */
    public function target(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'target_id', 'id');
    }

    /**
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    /**
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }

    /**
     */
    public function timelineElement(): BelongsTo
    {
        return $this->belongsTo('App\Models\TimelineElement', 'timeline_element_id', 'id');
    }

    /**
     */
    public function questElement(): BelongsTo
    {
        return $this->belongsTo('App\Models\QuestElement', 'quest_element_id', 'id');
    }

    /**
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * Determine if the mention goes to a post
     */
    public function isPost(): bool
    {
        return !empty($this->post_id);
    }

    /**
     * Determine if the mention goes to an entity
     */
    public function isEntity(): bool
    {
        return !empty($this->entity_id);
    }

    /**
     * Determine if the mention goes to a timeline element
     */
    public function isTimelineElement(): bool
    {
        return !empty($this->timeline_element_id);
    }

    /**
     * Determine if the mention goes to a quest element
     */
    public function isQuestElement(): bool
    {
        return !empty($this->quest_element_id);
    }

    /**
     * Determine if the mention goes to a campaign
     */
    public function isCampaign(): bool
    {
        return !empty($this->campaign_id);
    }

    /**
     * Build the query that will loop on the various mentions to get the total count.
     * The AclTrait on entities and posts makes sure only visible things get added to the query.
     */
    public function scopeFilterValid(Builder $query): Builder
    {
        return $query->where(function ($sub) {
            return $sub
                ->where(function ($subEnt) {
                    // @phpstan-ignore-next-line
                    return $subEnt
                        ->onEntity()
                        ->has('entity');
                })
                ->orWhere(function ($subPost) {
                    // @phpstan-ignore-next-line
                    return $subPost
                        ->onPost()
                        ->has('post.entity');
                })
                ->orWhere(function ($subQuestElement) {
                    // @phpstan-ignore-next-line
                    return $subQuestElement
                        ->onQuestElement()
                        ->has('questElement.quest.entity');
                })
                ->orWhere(function ($subTimelineElement) {
                    // @phpstan-ignore-next-line
                    return $subTimelineElement
                        ->onTimelineElement()
                        ->has('timelineElement.timeline.entity');
                })
                ->orWhere(function ($subCam) {
                    // @phpstan-ignore-next-line
                    return $subCam->onCampaign();
                });
        });
    }

    /**
     */
    public function scopeOnEntity(Builder $query): Builder
    {
        return $query->where(function ($sub) {
            $sub->whereNotNull('entity_mentions.entity_id')
                ->whereNull('entity_mentions.post_id')
                ->whereNull('entity_mentions.timeline_element_id')
                ->whereNull('entity_mentions.quest_element_id')
            ;
        });
    }

    /**
     */
    public function scopeOnPost(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.post_id');
    }

    /**
     */
    public function scopeOnTimelineElement(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.timeline_element_id');
    }

    /**
     */
    public function scopeOnQuestElement(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.quest_element_id');
    }

    /**
     */
    public function scopeOnCampaign(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.campaign_id');
    }

    /**
     */
    public function scopeDatagridElements(Builder $query, array $options): Builder
    {
        $column = Arr::get($options, 'k', 'name');
        $order = Arr::get($options, 'o', 'ASC');
        $query->select('entity_mentions.*')
            ->leftJoin('entities as e', 'e.id', 'entity_mentions.entity_id')
        ;

        if ($column == 'name') {
            $query->orderByRaw('CASE WHEN e.name IS NULL THEN 1 ELSE 0 END');
            $query->orderBy('e.name', $order);
        } elseif ($column == 'type') {
            $query->orderByRaw('CASE WHEN e.type_id IS NULL THEN 1 ELSE 0 END');
            $query->orderBy('e.type_id', $order);
        }
        return $query
            ->orderBy('campaign_id')
        ;
    }

    /**
     * Todo: move this out of the model
     */
    public function getLink(): string
    {
        $campaign = CampaignLocalization::getCampaign();
        if ($this->isQuestElement()) {
            return route('quests.quest_elements.index', [$campaign, $this->entity->entity_id, '#quest-element-' . $this->quest_element_id]);
        } elseif ($this->isTimelineElement()) {
            return route('entities.show', [$campaign, $this->entity, '#timeline-element-' . $this->timeline_element_id]);
        } elseif ($this->isPost()) {
            return route('entities.show', [$campaign, $this->entity, '#post-' . $this->post_id]);
        }
        return '#';
    }

    /**
     * Determine if the mention is linked to an entity.
     * In theory, this is true for everything except a campaign mention, but in practice it's more complicated.
     */
    public function hasEntity(): bool
    {
        return !empty($this->entity_id) && !empty($this->entity);
    }

    public function exportFields(): array
    {
        return [
            'entity_id',
            'campaign_id',
            'post_id',
            'timeline_element_id',
            'quest_element_id',
            'target_id'
        ];
    }
}
