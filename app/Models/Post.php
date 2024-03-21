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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $id
 * @property integer $entity_id
 * @property string $name
 * @property string $value
 * @property string $entry
 * @property \App\Enums\Visibility $visibility_id
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
 * @property PostPermission[]|Collection $permissions
 * @property ImageMention[]|Collection $imageMentions
 *
 * @method static Builder|self pinned()
 */
class Post extends Model
{
    use Acl;
    use Blameable;
    use HasFactory;
    use Paginatable;
    use Searchable;
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
        return $this->hasMany(PostPermission::class, 'post_id', 'id');
    }

    /**
     * List of entities that mention this entity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentions()
    {
        return $this->hasMany('App\Models\EntityMention', 'post_id', 'id');
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
     * Copy an post to another target
     * @return Post
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
     */
    public function getEntryForEditionAttribute()
    {
        $text = Mentions::parseForEdit($this);
        return $text;
    }

    /**
     * @return Builder
     */
    public function scopeOrdered(Builder $query)
    {
        return $query
            ->orderBy('position');
    }

    /**
     */
    public function collapsed(): bool
    {
        return Arr::get($this->settings, 'collapsed', false);
    }

    /**
     */
    public function editingUsers()
    {
        return $this->belongsToMany(User::class, 'entity_user', 'post_id')
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
            ->leftJoin('entities', $this->getTable() . '.entity_id', '=', 'entities.id')
            ->has('entity')
            ->with('entity');
    }

    public function toSearchableArray()
    {
        return [
            'campaign_id' => $this->entity->campaign_id,
            'entity_id' => $this->entity_id,
            'name' => $this->name,
            'type'  => 'post',
            'entry' => $this->entry,
        ];
    }
}
