<?php

namespace App\Models;

use App\Facades\Mentions;
use App\User;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibilityIDTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * Class QuestCharacter
 * @package App\Models
 * @property integer $entity_id
 * @property string $name
 * @property integer $quest_id
 * @property string $description
 * @property string $role
 * @property string $colour
 * @property Quest|null $quest
 * @property Entity|null $entity
 *
 */
class QuestElement extends Model
{
    use Blameable;
    use HasFactory;
    /**
     * Traits
     */
    use SimpleSortableTrait;
    use VisibilityIDTrait;
    use Searchable;

    /** @var string[]  */
    protected $fillable = [
        'quest_id',
        'name',
        'entity_id',
        'description',
        'role',
        'colour',
        'visibility_id'
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
     */
    public function entry()
    {
        return Mentions::mapAny($this, 'description');
    }

    /**
     */
    public function getEntryForEditionAttribute()
    {
        $text = Mentions::parseForEdit($this, 'description');
        return $text;
    }

    /**
     */
    public function colourClass(): string
    {
        if (empty($this->colour)) {
            return 'bg-none';
        }

        return $this->colour == 'grey' ? 'bg-gray' : 'bg-' . $this->colour;
    }

    /**
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
     */
    public function hasEntity(): bool
    {
        return false;
    }

    /**
     * List of entities that mention this entity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentions()
    {
        return $this->hasMany('App\Models\EntityMention', 'quest_element_id', 'id');
    }

    /**
     */
    public function editingUsers()
    {
        return $this->belongsToMany(User::class, 'entity_user')
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }

    /**
     * Get the value used to index the model.
     *
     * @return mixed
     */
    public function getScoutKey()
    {
        return $this->getTable() . '_' . $this->id;
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'entities';
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query
        ->select([$this->getTable() . '.*', 'entities.id as entity_id'])
        ->leftJoin('quests', 'quests.id', '=', 'quest_elements.quest_id')
        ->leftJoin('entities', function ($join) { 
            $join->on('entities.entity_id', $this->getTable() . '.id');
        });
    }

    public function toSearchableArray()
    {
        return [
            'campaign_id' => $this->quest->entity->campaign_id,
            'entity_id' => $this->quest->entity->id,
            'entity_name' => $this->quest->entity->name,
            'name' => $this->name,
            'type'  => 'quest_element',
            'entry' => $this->description,
        ];
    }
}
