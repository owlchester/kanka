<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityMention
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $entity_note_id
 * @property integer $campaign_id
 * @property integer $target_id
 * @property Entity $entity
 * @property EntityNote $entityNote
 * @property Entity $target
 * @property Campaign $campaign
 *
 * @method static self|Builder prepareCount()
 */
class EntityMention extends Model
{
    public $fillable = [
        'entity_id',
        'entity_note_id',
        'campaign_id',
        'target_id'
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
    public function entityNote()
    {
        return $this->belongsTo('App\Models\EntityNote', 'entity_note_id', 'id');
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
    public function isEntityNote(): bool
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
                        ->entityNote()
                        ->has('entityNote.entity');
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
    public function scopeEntityNote(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.entity_note_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeCampaign(Builder $query): Builder
    {
        return $query->whereNotNull('entity_mentions.campaign_id');
    }
}
