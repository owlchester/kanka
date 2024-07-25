<?php

namespace App\Models;

use App\Facades\QuestCache;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasSuggestions;
use App\User;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibilityIDTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

/**
 * Class QuestCharacter
 * @package App\Models
 * @property int $entity_id
 * @property string $name
 * @property int $quest_id
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
    use HasEntry;
    use HasFactory;
    use HasSuggestions;
    use Searchable;
    use SimpleSortableTrait;
    use VisibilityIDTrait;

    protected string $entryField = 'description';

    protected $fillable = [
        'quest_id',
        'name',
        'entity_id',
        'description',
        'role',
        'colour',
        'visibility_id'
    ];

    public $casts = [
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected array $suggestions = [
        QuestCache::class => 'clearSuggestion',
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
    public function editingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'entity_user')
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }

    /**
     * Get the value used to index the model.
     *
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
            })
            ->has('quest')
            ->has('quest.entity')
            ->with('quest', 'quest.entity');
    }

    public function toSearchableArray()
    {
        return [
            'campaign_id' => $this->quest->entity->campaign_id,
            'entity_id' => $this->quest->entity->id,
            'name' => $this->name,
            'type'  => 'quest_element',
            'entry' => strip_tags($this->description),
        ];
    }
}
