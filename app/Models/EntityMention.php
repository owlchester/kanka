<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityMention
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $target_id
 * @property Entity $entity
 * @property Entity $target
 */
class EntityMention extends Model
{
    public $fillable = [
        'entity_id',
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
    public function target()
    {
        return $this->belongsTo('App\Models\Entity', 'target_id', 'id');
    }
}