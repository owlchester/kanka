<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\EntityAsset;
use App\Traits\VisibilityIDTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityLink
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $created_by
 * @property string $name
 * @property integer $visibility_id
 * @property Entity $entity
 * @property User $user
 * @property Campaign $campaign
 * @property Visibility $visibility
 */
class EntityAlias extends Model
{
    use VisibilityIDTrait, Blameable, EntityAsset;

    public $fillable = [
        'entity_id',
        'created_by',
        'name',
        'visibility_id',
    ];

    /** EntityAsset booleans */
    protected $isLink = false;
    protected $isFile = false;
    protected $isAlias = true;

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
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visibility()
    {
        return $this->belongsTo('App\Models\Visibility', 'visibility_id');
    }

    /**
     * Copy an entity link to another target
     * @param Entity $target
     */
    public function copyTo(Entity $target)
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        return $new->save();
    }
}
