<?php

namespace App\Models;

use App\Facades\UserPermission;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\SimpleSortableTrait;
use App\Models\Scopes\Starred;
use App\Traits\OrderableTrait;
use App\Traits\VisibilityTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use Exception;

/**
 * Class Relation
 * @package App\Models
 * @property int $id
 * @property string $visibility
 * @property string $relation
 * @property int $attitude
 * @property int $mirror_id
 * @property int $owner_id
 * @property int $target_id
 * @property bool $is_star
 * @property string $colour
 * @property Relation $mirror
 * @property Relation $target
 * @property Relation $owner
 */
class Relation extends Model
{

    /**
     * Traits
     */
    use VisibilityTrait, Starred, Paginatable, Blameable, SimpleSortableTrait;

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
        'colour',
    ];

    /**
     * @param $query
     * @param int $star
     * @return mixed
     */
    public function scopeOrdered($query, $order = 'desc')
    {
        return $query->orderBy('attitude', $order)->orderBy('relation');
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
            'colour' => $this->colour,
            'visibility' => $this->visibility,
            'is_star' => $this->is_star,
            'mirror_id' => $this->id,
        ]);

        // Update this relation to keep track of everything
        $this->update(['mirror_id' => $mirror->id]);
    }
    /**
     * Scope a query to only include elements that are visible
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAcl($query, $action = 'read', $user = null)
    {
        // Use the User Permission Service to handle all of this easily.
        /** @var \App\Services\UserPermission $service */
        $service = UserPermission::user($user)->action($action);

        if ($service->isCampaignOwner()) {
            return $query;
        }

        return $query
            ->select('relations.*')
            ->join('entities', 'relations.target_id', '=', 'entities.id')
            ->where('entities.is_private', false)
            ->where(function ($subquery) use ($service) {
                return $subquery
                    ->where(function ($sub) use ($service) {
                        return $sub->whereIn('entities.id', $service->entityIds())
                            ->orWhereIn('entities.type', $service->entityTypes());
                    })
                    ->whereNotIn('entities.id', $service->deniedEntityIds());
            });
    }

    /**
     * When setting the colour, remove the '#' from the db
     * @param $colour
     */
    public function setColourAttribute($colour)
    {
        $this->attributes['colour'] = ltrim($colour, '#');
    }

    /**
     * When setting the colour, remove the '#' from the db
     * @param $colour
     */
    public function getColourAttribute(): string
    {
        if (empty($this->attributes['colour'])) {
            return '';
        }
        return '#' . $this->attributes['colour'];
    }
}
