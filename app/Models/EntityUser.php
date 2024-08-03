<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EntityUser
 * @package App\Models
 *
 * @property int $id
 * @property int $entity_id
 * @property int $campaign_id
 * @property int $post_id
 * @property int $timeline_element_id
 * @property int $quest_element_id
 * @property int $type_id
 *
 * @property Entity $entity
 *
 * @method static self|Builder keepAlive()
 * @method static self|Builder userID(int $userID)
 * @method static self|Builder campaignID(int $campaignID)
 */
class EntityUser extends Pivot
{
    use HasUser;
    use MassPrunable;

    public const TYPE_KEEPALIVE = 1;

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function timelineElement(): BelongsTo
    {
        return $this->belongsTo(TimelineElement::class, 'timeline_element_id');
    }

    public function questElement(): BelongsTo
    {
        return $this->belongsTo(QuestElement::class, 'quest_element_id');
    }

    public function scopeKeepAlive(Builder $query): Builder
    {
        return $query->where('type_id', self::TYPE_KEEPALIVE);
    }

    public function scopeUserID(Builder $query, int $userID): Builder
    {
        return $query->where('user_id', $userID);
    }

    public function scopeCampaignID(Builder $query, int $campaignID): Builder
    {
        return $query->where('campaign_id', $campaignID);
    }

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
    {
        return static::keepAlive()
            ->where('created_at', '<=', now()->subDay());
    }
}
