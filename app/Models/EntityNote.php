<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\Paginatable;
use App\Traits\VisibilityIDTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $id
 * @property integer $entity_id
 * @property string $name
 * @property string $value
 * @property string $entry
 * @property int $visibility_id
 * @property integer $created_by
 * @property integer|null $location_id
 * @property integer|null $layout_id
 * @property string|null $marketplace_uuid
 * @property boolean $is_private
 * @property boolean $is_pinned
 * @property integer $position
 * @property array $settings
 * @property Entity|null $entity
 * @property Location|null $location
 * @property PostLayout|null $layout
 * @property EntityMention[]|Collection $mentions
 * @property EntityNotePermission[]|Collection $permissions
 * @property ImageMention[]|Collection $imageMentions
 *
 * @method static Builder|self pinned()
 */
class EntityNote extends Model
{
    use Acl;
    use Blameable;
    use Paginatable;
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
        'layout_id',
    ];

    /** @var array<string, string>  */
    public $casts = [
        'settings' => 'array',
        'visibility_id' => \App\Enums\Visibility::class,
    ];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function layout()
    {
        return $this->belongsTo('App\Models\PostLayout', 'layout_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(EntityNotePermission::class, 'post_id', 'id');
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
     * List of images that mention this entity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imageMentions()
    {
        return $this->hasMany('App\Models\ImageMention', 'post_id', 'id');
    }

    /**
     * Copy an entity note to another target
     * @param Entity $target
     * @return Post|EntityNote
     */
    public function copyTo(Entity $target)
    {
        $new = $this->replicate(['entity_id', 'created_by']);
        $new->entity_id = $target->id;
        $new->created_by = auth()->user()->id;
        $new->saveQuietly();

        // Also replicate permissions
        foreach ($this->permissions as $perm) {
            $newPerm = $perm->replicate(['post_id']);
            $newPerm->post_id = $new->id;
            $newPerm->save();
        }

        return $new;
    }

    /**
     * @return mixed
     */
    public function entry()
    {
        return Mentions::mapPost($this);
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
    public function editingUsers()
    {
        return $this->belongsToMany(User::class, 'entity_user', 'post_id')
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }
}
