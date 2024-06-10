<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\SortableTrait;
use Illuminate\Support\Arr;

/**
 * Class EntityMention
 * @package App\Models
 *
 * @property int $entity_id
 * @property int|null $post_id
 * @property int|null $quest_element_id
 * @property int|null $timeline_element_id
 * @property int|null $campaign_id
 * @property int $target_id
 * @property Entity $entity
 * @property Post|null $post
 * @property QuestElement|null $questElement
 * @property TimelineElement|null $timelineElement
 * @property Entity|null $target
 * @property Campaign|null $campaign
 *
 * @method static self|Builder prepareCount()
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
        'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function target()
    {
        return $this->belongsTo('App\Models\Entity', 'target_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timelineElement()
    {
        return $this->belongsTo('App\Models\TimelineElement', 'timeline_element_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questElement()
    {
        return $this->belongsTo('App\Models\QuestElement', 'quest_element_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
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
    public function scopePrepareCount(Builder $query): Builder
    {
        return $query->where(function ($sub) {
            return $sub
                ->where(function ($subEnt) {
                    // @phpstan-ignore-next-line
                    return $subEnt
                        ->entity()
                        ->has('entity');
                })
                ->orWhere(function ($subPost) {
                    // @phpstan-ignore-next-line
                    return $subPost
                        ->post()
                        ->has('post.entity');
                })
                ->orWhere(function ($subQuestElement) {
                    // @phpstan-ignore-next-line
                    return $subQuestElement
                        ->questElement()
                        ->has('questElement.entity');
                })
                ->orWhere(function ($subTimelineElement) {
                    // @phpstan-ignore-next-line
                    return $subTimelineElement
                        ->timelineElement()
                        ->has('timelineElement.entity');
                })
                ->orWhere(function ($subCam) {
                    // @phpstan-ignore-next-line
                    return $subCam->campaign();
                });
        });
    }

    /**
     */
    public function scopeEntity(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.entity_id');
    }

    /**
     */
    public function scopePost(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.post_id');
    }

    /**
     */
    public function scopeTimelineElement(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.timeline_element_id');
    }

    /**
     */
    public function scopeQuestElement(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.quest_element_id');
    }

    /**
     */
    public function scopeCampaign(Builder $query): Builder
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

    /**
     * Get the entity link with ajax tooltip.
     * When coming from an entity first, call this method on the entity. It avoids some back and worth.
     * Todo: move this out of the model
     */
    public function mentionLink(): string
    {
        if ($this->isQuestElement()) {
            if ($this->questElement && $this->entity) {
                return $this->entity->tooltipedLink() .
                    ' - ' . $this->questElement->skipAllIcon()->visibilityIcon() .
                    ' <a class="name" href="' .
                    $this->getLink() . '">' .
                    $this->questElement->name() .
                    '</a>';
            }
            return 'Unknown';
        } elseif ($this->isTimelineElement()) {
            if ($this->timelineElement && $this->entity) {
                return $this->entity->tooltipedLink() .
                    ' - ' . $this->timelineElement->skipAllIcon()->visibilityIcon() .
                    ' <a class="name" href="' .
                    $this->getLink() . '">' .
                    $this->timelineElement->elementName() .
                    '</a>';
            }
        } elseif ($this->isPost()) {
            if ($this->post && $this->entity) {
                return $this->entity->tooltipedLink() .
                    ' - ' . $this->post->skipAllIcon()->visibilityIcon() .
                    ' <a class="name" href="' .
                    $this->getLink() . '">' .
                    $this->post->name .
                    '</a>';
            }
        } elseif ($this->entity) {
            return $this->entity->tooltipedLink();
        } elseif ($this->isCampaign()) {
            return '<a class="name" href="' .
                route('overview', $this->campaign) . '">' .
                $this->campaign->name .
                '</a>';
        }
        return __('crud.hidden');
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
