<?php

namespace App\Models;

use App\Models\Concerns\EntityAsset;
use App\Traits\VisibilityIDTrait;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityLink
 * @package App\Models
 *
 * @property int $entity_id
 * @property int $created_by
 * @property string $name
 * @property int $position
 * @property string $icon
 * @property string $url
 * @property Entity $entity
 * @property User $user
 * @property Campaign $campaign
 */
class EntityLink extends Model
{
    use EntityAsset;
    use VisibilityIDTrait;

    public $fillable = [
        'entity_id',
        'created_by',
        'name',
        'url',
        'icon',
        'position',
        'visibility_id',
    ];

    /** EntityAsset booleans */
    protected $isLink = true;
    protected $isFile = false;
    protected $isAlias = false;

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
     */
    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('position', 'ASC');
    }

    /**
     */
    public function iconName(): string
    {
        if (empty($this->icon)) {
            return 'fa-solid fa-external-link';
        }

        return (string) $this->icon;
    }

    /**
     * Copy an entity link to another target
     */
    public function copyTo(Entity $target)
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        return $new->save();
    }
}
