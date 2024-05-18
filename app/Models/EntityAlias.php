<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\EntityAsset;
use App\Traits\VisibilityIDTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class EntityLink
 * @package App\Models
 *
 * @property int $entity_id
 * @property int $created_by
 * @property string $name
 * @property int $visibility_id
 * @property Entity $entity
 * @property User $user
 * @property Campaign $campaign
 * @property Visibility $visibility
 */
class EntityAlias extends Model
{
    use Blameable;
    use EntityAsset;
    use VisibilityIDTrait;

    public $fillable = [
        'entity_id',
        'created_by',
        'name',
        'visibility_id',
    ];

    /** EntityAsset booleans */
    protected bool $isLink = false;
    protected bool $isFile = false;
    protected bool $isAlias = true;

    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function visibility(): BelongsTo
    {
        return $this->belongsTo('App\Models\Visibility', 'visibility_id');
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
