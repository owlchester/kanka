<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Models\Concerns\Templatable;
use App\Traits\HasVisibility;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property int $id
 * @property int $entity_id
 * @property string $name
 * @property string $value
 * @property string $entry
 * @property \App\Enums\Visibility $visibility_id
 * @property int $created_by
 * @property int|null $location_id
 * @property int|null $layout_id
 * @property string|null $marketplace_uuid
 * @property bool|int $is_private
 * @property int $deleted_by
 * @property bool|int $is_template
 * @property int $position
 * @property array $settings
 * @property Entity|null $entity
 * @property Location|null $location
 * @property PostLayout|null $layout
 * @property EntityMention[]|Collection $mentions
 * @property PostPermission[]|Collection $permissions
 * @property ImageMention[]|Collection $imageMentions
 * @property Carbon $deleted_at
 *
 * @method static Builder|self pinned()
 */
class Post extends Model
{
    use Acl;
    use Blameable;
    use HasEntry;
    use HasFactory;
    use HasVisibility;
    use Paginatable;
    use Sanitizable;
    use Searchable;
    use SoftDeletes;
    use SortableTrait;
    use Templatable;

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
        'is_template'
    ];

    /** @var string[] Fields that can be used to order by */
    protected array $sortable = [
        'name',
        'deleted_at',
    ];

    /** @var array<string, string>  */
    public $casts = [
        'settings' => 'array',
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected array $sanitizable = [
        'name',
    ];

    /**
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }

    /**
     */
    public function layout(): BelongsTo
    {
        return $this->belongsTo('App\Models\PostLayout', 'layout_id');
    }

    /**
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(PostPermission::class, 'post_id', 'id');
    }

    /**
     * List of entities that mention this entity
     */
    public function mentions(): HasMany
    {
        return $this->hasMany('App\Models\EntityMention', 'post_id', 'id');
    }

    /**
     * List of logs for this post
     */
    public function logs(): HasMany
    {
        return $this->hasMany('App\Models\EntityLog', 'post_id', 'id');
    }

    /**
     * List of images that mention this entity
     */
    public function imageMentions(): HasMany
    {
        return $this->hasMany('App\Models\ImageMention', 'post_id', 'id');
    }

    /**
     * Copy a post to another target
     */
    public function copyTo(Entity $target): Post
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
    public function scopeOrdered(Builder $query): Builder
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
    public function editingUsers(): BelongsToMany
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
            'entry' => strip_tags($this->entry),
        ];
    }
}
