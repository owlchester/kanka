<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\Paginatable;
use App\Models\Scopes\Starred;
use App\Traits\OrderableTrait;
use App\Traits\VisibilityTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use Exception;

/**
 * Class Relation
 * @package App\Models
 * @property string $visibility
 * @property string $relation
 * @property int $attitude
 * @property int $mirror_id
 * @property int $owner_id
 * @property int $target_id
 * @property bool $is_star
 * @property Relation $mirror
 * @property Relation $target
 * @property Relation $owner
 */
class Relation extends Model
{

    /**
     * Traits
     */
    use VisibilityTrait, OrderableTrait, Starred, Paginatable, Blameable;

    /**
     * Trigger for filtering based on the order request.
     * @var string
     */
    protected $orderTrigger = 'relations/';
    protected $orderDefaultField = 'attitude';
    protected $orderDefaultDir = 'desc';

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'owner_id',
        'target_id',
        'relation',
        'visibility',
        'mirror_id',
        'attitude',
        'is_star',
    ];

    /**
     * @param $query
     * @param int $star
     * @return mixed
     */
    public function scopeOrdered($query, $order = 'desc')
    {
        return $query->orderBy('attitude', $order);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\Entity', 'owner_id', 'id');
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
    public function mirror()
    {
        return $this->belongsTo('App\Models\Relation', 'mirror_id', 'id');
    }

    /**
     * Check if a relation is mirrored
     * @return bool
     */
    public function mirrored(): bool
    {
        return !empty($this->mirror_id);
    }

    /**
     * Create a mirror of the relation
     */
    public function createMirror(): void
    {
        $mirror = Relation::create([
            'owner_id' => $this->target_id,
            'target_id' => $this->owner_id,
            'campaign_id' => $this->campaign_id,
            'relation' => $this->relation,
            'attitude' => $this->attitude,
            'visibility' => $this->visibility,
            'is_star' => $this->is_star,
            'mirror_id' => $this->id,
        ]);

        // Update this relation to keep track of everything
        $this->update(['mirror_id' => $mirror->id]);
    }
}
