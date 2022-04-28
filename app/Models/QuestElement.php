<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibilityTrait;
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

    /**
     * For the legacy editor
     * @return bool
     */
    public function hasEntity(): bool
    {
        return false;
    }
}
