<?php


namespace App\Models;

use App\Facades\Mentions;
use App\Facades\UserPermission;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TimelineElement
 * @package App\Models
 *
 * @property int $id
 * @property int $timeline_id
 * @property int $timeline_era
 * @property int $entity_id
 * @property string $name
 * @property string $entry
 * @property string $date
 * @property int $position
 * @property string $colour
 *
 * @property Timeline $timeline
 * @property TimelineEra $era
 * @property Entity $entity
 *
 * @method static self|Builder ordered()
 */
class TimelineElement extends Model
{
    use VisibilityTrait, Blameable, SimpleSortableTrait;

    /** Fillable fields */
    protected $fillable = [
        'timeline_id',
        'era_id',
        'entity_id',
        'name',
        'entry',
        'position',
        'name',
        'colour',
        'visibility',
        'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function era()
    {
        return $this->belongsTo(TimelineEra::class, 'era_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered(Builder $query)
    {
        return $query
            ->with('entity')
            ->orderBy('position');
    }

    /**
     * @return string
     */
    public function elementName(): string
    {
        if (!empty($this->entity_id)) {
            return $this->entity->name;
        }
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEntryForEditionAttribute()
    {
        $text = Mentions::editAny($this);
        return $text;
    }

    /**
     * @return mixed
     */
    public function entry()
    {
        return Mentions::mapAny($this);
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
            ->select('timeline_elements.*')
            ->join('entities', 'entities.id', '=', 'timeline_elements.entity_id')
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
}
