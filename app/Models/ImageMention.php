<?php

namespace App\Models;

use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ImageMention
 *
 * @property string $image_id
 * @property int $post_id
 * @property int $entity_id
 * @property Entity $entity
 * @property Post $post
 * @property Entity $target
 *
 * @method static self|Builder prepareCount()
 */
class ImageMention extends Model
{
    use SortableTrait;

    public $fillable = [
        'entity_id',
        'image_id',
        'post_id',
    ];

    protected array $sortable = [
        'name',
        'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Entity, $this>
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }

    /**
     * Determine if the mention goes to a post
     */
    public function isPost(): bool
    {
        return ! empty($this->post_id);
    }

    /**
     * Build the query that will loop on the various mentions to get the total count.
     * The AclTrait on entities and posts makes sure only visible things get added to the query.
     */
    public function scopePrepareCount(Builder $query): Builder
    {
        return $query->where(function ($sub) {
            return $sub
                ->where(function ($subEnt) {
                    // @phpstan-ignore-next-line
                    return $subEnt
                        ->entity()
                        ->has('entity');
                })
                ->orWhere(function ($subPost) {
                    // @phpstan-ignore-next-line
                    return $subPost
                        ->post()
                        ->has('post.entity');
                });
        });
    }

    public function scopeEntity(Builder $query): Builder
    {
        return $query->whereNotNull('image_mentions.entity_id');
    }

    public function scopePost(Builder $query): Builder
    {
        return $query->whereNotNull('image_mentions.post_id');
    }
}
