<?php

namespace App\Models\Concerns;

use App\Models\EntityMention;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @property EntityMention[]|Collection $mentions
 * @property EntityMention[]|Collection $targetMentions
 * @method static self|Builder unmentioned()
 * @method static self|Builder mentionless()
 */
trait HasMentions
{
    /**
     * List of entities that this entity mentions
     */
    public function mentions(): HasMany
    {
        return $this->hasMany('App\Models\EntityMention', 'entity_id', 'id');
    }

    /**
     * List of images used by this entity
     */
    public function imageMentions(): HasMany
    {
        return $this->hasMany('App\Models\ImageMention', 'entity_id', 'id');
    }

    /**
     * List of entities that mention this entity
     */
    public function targetMentions(): HasMany
    {
        return $this->hasMany('App\Models\EntityMention', 'target_id', 'id');
    }
    /**
     * Get entities that are unmentioned
     */
    public function scopeUnmentioned(Builder $query): Builder
    {
        return $query->select([
            $this->getTable() . '.*'
        ])
            ->leftJoin('entity_mentions as em', 'em.target_id', $this->getTable() . '.id')
            ->whereNull('em.id');
    }

    /**
     * Get entities that aren't mentioned anywhere
     */
    public function scopeMentionless(Builder $query): Builder
    {
        return $query->select($this->getTable() . '.*')
            ->leftJoin('entity_mentions as em', 'em.entity_id', $this->getTable() . '.id')
            ->whereNull('em.id');
    }

    /**
     * Count the number of mentions this entity has
     */
    public function mentionsCount(): int
    {
        return $this->targetMentions()
            ->filterValid()
            ->count();
    }
}
