<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Facades\UserPermission;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibilityTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestCharacter
 * @package App\Models
 * @property integer $entity_id
 * @property string $name
 * @property integer $quest_id
 * @property string $description
 * @property string $role
 * @property string $colour
 * @property Quest $quest
 * @property Entity $entity
 *
 */
class QuestElement extends Model
{
    /**
     * Traits
     */
    use SimpleSortableTrait, VisibilityTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'quest_id',
        'name',
        'entity_id',
        'description',
        'role',
        'colour',
        'visibility'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quest()
    {
        return $this->belongsTo('App\Models\Quest', 'quest_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
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
            ->select('quest_elements.*')
            ->join('entities', 'quest_elements.entity_id', '=', 'entities.id')
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
     * @return mixed
     */
    public function entry()
    {
        return Mentions::mapAny($this, 'description');
    }

    /**
     * @return mixed
     */
    public function getEntryForEditionAttribute()
    {
        $text = Mentions::editAny($this, 'description');
        return $text;
    }

    /**
     * @return string
     */
    public function colourClass(): string
    {
        if (empty($this->colour)) {
            return 'bg-none';
        }

        return $this->colour == 'grey' ? 'bg-gray' : 'bg-' . $this->colour;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        if (empty($this->name) && $this->entity) {
            return $this->entity->name;
        }

        return (string) $this->name;

    }
}
