<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasLocation;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Models\Concerns\Taggable;
use App\Models\Concerns\Templatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;

/**
 * Class Post
 * @package App\Models
 *
 * @property int $id
 * @property int $entity_id
 * @property string $name
 * @property string $value
 * @property string $entry
 * @property \App\Enums\Visibility $visibility_id
 * @property ?int $layout_id
 * @property ?string $marketplace_uuid
 * @property bool|int $is_private
 * @property int $deleted_by
 * @property bool|int $is_template
 * @property int $position
 * @property array $settings
 * @property ?Entity $entity
 * @property PostLayout|null $layout
 * @property EntityMention[]|Collection $mentions
 * @property PostPermission[]|Collection $permissions
 * @property ImageMention[]|Collection $imageMentions
 * @property PostTag[] $postTags
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
    use HasLocation;
    use HasVisibility;
    use Paginatable;
    use Sanitizable;
    use Searchable;
    use SoftDeletes;
    use SortableTrait;
    use Templatable;
    use Taggable;

    /** @var Collection List of tags attached to the entity */
    protected Collection $tagsWithEntity;

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
    public function copyTo(Entity $target, bool $sameCampaign): Post
    {
        $without = ['entity_id', 'created_by', 'updated_by', 'is_template'];
        if (!$sameCampaign) {
            $without[] = 'location_id';
        }
        $new = $this->replicate($without);
        $new->entity_id = $target->id;
        $new->created_by = auth()->user()->id;
        $new->saveQuietly();

        if (!$sameCampaign) {
            return $new;
        }
        foreach ($this->permissions as $perm) {
            $newPerm = $perm->replicate(['post_id']);
            $newPerm->post_id = $new->id;
            $newPerm->save();
        }
        foreach ($this->postTags as $tag) {
            $newTag = $tag->replicate(['post_id']);
            $newTag->post_id = $new->id;
            $newTag->save();
        }
        return $new;
    }

    public function postTags(): HasMany
    {
        return $this->hasMany(PostTag::class, 'post_id', 'id');
    }

    public function export(): array
    {
        $post = $this->toArray();
        if (array_key_exists('post_tags', $post)) { 
            foreach ($post['post_tags'] as $postTag)
            {
                $post['postTags'][] = ['tag_id' => $postTag['tag_id']];
            }
            unset($post['post_tags']);
        }
        return $post;
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

    /**
     * @return Collection|Tag[]
     */
    public function tagsWithEntity(bool $excludeHidden = false): Collection
    {
        if (!isset($this->tagsWithEntity)) {
            $this->tagsWithEntity = $this->tags()
                ->with('entity')
                ->has('entity')
                ->get();
        }
        if (!$excludeHidden) {
            return $this->tagsWithEntity->where('is_hidden', '=', '0');
        }
        return $this->tagsWithEntity;
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
