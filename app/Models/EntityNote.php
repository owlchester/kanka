<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\Paginatable;
use App\Traits\OrderableTrait;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $entity_id
 * @property string $name
 * @property string $value
 * @property string $entry
 * @property string $visibility
 * @property integer $created_by
 * @property boolean $is_private
 * @property EntityMention[] $mentions
 */
class EntityNote extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'name',
        'entry',
        'created_by',
        'is_private',
        'visibility'
    ];

    /**
     * Trigger for filtering based on the order request.
     * @var string
     */
    protected $orderTrigger = 'notes/';

    /**
     * Set to false to skip save observers
     * @var bool
     */
    public $savedObserver = true;

    /**
     * Traits
     */
    use VisibilityTrait, OrderableTrait, Paginatable, Blameable;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     * List of entities that mention this entity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentions()
    {
        return $this->hasMany('App\Models\EntityMention', 'entity_note_id', 'id');
    }

    /**
     * Copy an entity note to another target
     * @param Entity $target
     */
    public function copyTo(Entity $target)
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        return $new->save();
    }

    /**
     * @return mixed
     */
    public function entry()
    {
        return Mentions::mapEntityNote($this);
    }

    /**
     * @return mixed
     */
    public function getEntryForEditionAttribute()
    {
        $text = Mentions::editEntityNote($this);
        return $text;
    }
}
