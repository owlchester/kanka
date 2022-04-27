<?php

namespace App\Models;

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
    public function target()
    {
        return $this->belongsTo('App\Models\Entity', 'target_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return bool
     */
    public function isEntityNote()
    {
        return !empty($this->entity_note_id);
    }

    /**
     * @return bool
     */
    public function isEntity()
    {
        return !empty($this->entity_id);
    }

    /**
     * @return bool
     */
    public function isCampaign()
    {
        return !empty($this->campaign_id);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeEntity($query)
    {
        return $query->whereNotNull('entity_mentions.entity_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeEntityNote($query)
    {
        return $query->whereNotNull('entity_mentions.entity_note_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCampaign($query)
    {
        return $query->whereNotNull('entity_mentions.campaign_id');
    }
}
