<?php

namespace App\Models;

use App\Models\Concerns\SimpleSortableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityCategory
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $tag_id
 * @property Tag $tag
 * @property Entity $entity
 */
class EntityTag extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'tag_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }
}
