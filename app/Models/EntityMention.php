<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\SortableTrait;
use Illuminate\Support\Arr;

/**
 * Class EntityMention
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $entity_note_id
 * @property integer $quest_element_id
 * @property integer $timeline_element_id
 * @property integer $campaign_id
 * @property integer $target_id
 * @property Entity $entity
 * @property Post $post
 * @property QuestElement $questElement
 * @property TimelineElement $timelineElement
 * @property Entity $target
 * @property Campaign $campaign
 *
 * @method static self|Builder prepareCount()
 */
class EntityMention extends Model
{
    use SortableTrait;

    public $fillable = [
        'entity_id',
        'entity_note_id',
        'timeline_element_id',
        'quest_element_id',
        'campaign_id',
        'target_id'
    ];

    protected $sortable = [
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
        return $this->belongsTo('App\Models\Post', 'entity_note_id', 'id');
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
     * @return bool
     */
    public function isPost(): bool
    {
        return !empty($this->entity_note_id);
    }

    /**
     * Determine if the mention goes to an entity
     * @return bool
     */
    public function isEntity(): bool
    {
        return !empty($this->entity_id);
    }

    /**
     * Determine if the mention goes to a timeline element
     * @return bool
     */
    public function isTimelineElement(): bool
    {
        return !empty($this->timeline_element_id);
    }

    /**
     * Determine if the mention goes to a quest element
     * @return bool
     */
    public function isQuestElement(): bool
    {
        return !empty($this->quest_element_id);
    }

    /**
     * Determine if the mention goes to a campaign
     * @return bool
     */
    public function isCampaign(): bool
    {
        return !empty($this->campaign_id);
    }

    /**
     * Build the query that will loop on the various mentions to get the total count.
     * The AclTrait on entities and posts makes sure only visible things get added to the query.
     * @param Builder $query
     * @return Builder
     */
    public function scopePrepareCount(Builder $query): Builder
    {
        return $query->where(function ($sub) {
            return $sub
                ->where(function ($subEnt) {
                    return $subEnt
                        ->entity()
                        ->has('entity');
                })
                ->orWhere(function ($subPost) {
                    return $subPost
                        ->post()
                        ->has('post.entity');
                })
                ->orWhere(function ($subQuestElement) {
                    return $subQuestElement
                        ->questElement()
                        ->has('questElement.entity');
                })
                ->orWhere(function ($subTimelineElement) {
                    return $subTimelineElement
                        ->timelineElement()
                        ->has('timelineElement.entity');
                })
                ->orWhere(function ($subCam) {
                    return $subCam->campaign();
                });
        });
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeEntity(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.entity_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePost(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.entity_note_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeTimelineElement(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.timeline_element_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeQuestElement(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.quest_element_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeCampaign(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.campaign_id');
    }

    /**
     * @param Builder $query
     * @return Builder
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
     * @return string
     */
    public function getLink(): string
    {
        if ($this->isQuestElement()) {
            return route('quests.quest_elements.index', [$this->entity->entity_id, '#quest-element-' . $this->quest_element_id]);
        } elseif ($this->isTimelineElement()) {
            return route('timelines.show', [$this->entity->entity_id, '#timeline-element-' . $this->timeline_element_id]);
        } elseif ($this->isPost()) {
            return route($this->post->entity->pluralType() . '.show', [$this->entity->entity_id, '#post-' . $this->entity_note_id]);
        }
        return '#';
    }

    /**
     * Determine if the mention is linked to an entity.
     * In theory, this is true for everything except a campaign mention, but in practice it's more complicated.
     * @return bool
     */
    public function hasEntity(): bool
    {
        return !empty($this->entity_id) && !empty($this->entity);
    }

    /**
     * Get the entity link with ajax tooltip.
     * When coming from an entity first, call this method on the entity. It avoids some back and worth.
     * @return string
     */
    public function mentionLink(): string
    {
        if ($this->isQuestElement()) {
            if ($this->questElement && $this->entity) {
                return $this->entity->tooltipedLink() .
                    ' - ' . $this->questElement->visibilityIcon(null, true) .
                    ' <a class="name" href="' .
                    $this->getLink() . '">' .
                    $this->questElement->name() .
                    '</a>';
            }
            return 'Unknown';
        } elseif ($this->isTimelineElement()) {
            if ($this->timelineElement && $this->entity) {
                return $this->entity->tooltipedLink() .
                    ' - ' . $this->timelineElement->visibilityIcon(null, true) .
                    ' <a class="name" href="' .
                    $this->getLink() . '">' .
                    $this->timelineElement->elementName() .
                    '</a>';
            }
        } elseif ($this->isPost()) {
            if ($this->post && $this->entity) {
                return $this->entity->tooltipedLink() .
                    ' - ' . $this->post->visibilityIcon(null, true) .
                    ' <a class="name" href="' .
                    $this->getLink() . '">' .
                    $this->post->name .
                    '</a>';
            }
        } elseif ($this->entity) {
            return $this->entity->tooltipedLink();
        } elseif ($this->isCampaign()) {
            return '<a class="name" href="' .
                route('campaign') . '">' .
                $this->campaign->name .
                '</a>';
        }
        return __('crud.hidden');
    }
}
