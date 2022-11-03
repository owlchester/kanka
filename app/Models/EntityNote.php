<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\Paginatable;
use App\Traits\VisibilityIDTrait;
use App\User;
use App\Models\EntityUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $entity_id
 * @property string $name
 * @property string $value
 * @property string $entry
 * @property int $visibility_id
 * @property integer $created_by
 * @property integer|null $location_id
 * @property string|null $marketplace_uuid
 * @property boolean $is_private
 * @property boolean $is_pinned
 * @property integer $position
 * @property array $settings
 * @property Entity|null $entity
 * @property Location|null $location
 * @property EntityMention[]|Collection $mentions
 * @property EntityNotePermission[]|Collection $permissions
 *
 * @method static Builder|self pinned()
 */
class EntityNote extends Model
{
    /** Traits */
    use Paginatable, Blameable, Acl;
    use VisibilityIDTrait;

    /** @var string[]  */
    protected $fillable = [
        'entity_id',
        'name',
        'entry',
        'created_by',
        'is_private',
        'is_pinned',
        'position',
        'visibility_id',
        'settings',
        'location_id',
    ];

    /** @var array<string, string>  */
    public $casts = [
        'settings' => 'array'
    ];

    /**
     * Set to false to skip saved observers
     * @var bool
     */
    public $savedObserver = true;

    /**
     * Set to false to skip saving observers
     * @var bool
     */
    public $savingObserver = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(EntityNotePermission::class);
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
        $result = $new->save();

        // Also replicate permissions
        foreach ($this->permissions as $perm) {
            $newPerm = $perm->replicate(['entity_note_id']);
            $newPerm->entity_note_id = $new->id;
            $newPerm->save();
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function entry()
    {
        return Mentions::mapEntityNote($this);
    }

    /**
     * @return bool
     */
    /*public function hasEntity(): bool
    {
        return true;
    }*/

    /**
     * @return mixed
     */
    public function getEntryForEditionAttribute()
    {
        $text = Mentions::parseForEdit($this);
        return $text;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered(Builder $query)
    {
        return $query
            ->orderBy('position');
    }

    /**
     * @return bool
     */
    public function collapsed(): bool
    {
        return Arr::get($this->settings, 'collapsed', false);
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'entity_user', 'post_id')
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }
}
