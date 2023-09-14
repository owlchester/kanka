<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\SortableTrait;

/**
 * Class ImageMention
 * @package App\Models
 *
 * @property string $image_id
 * @property integer $post_id
 * @property integer $entity_id
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

    protected $sortable = [
        'name',
        'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }

    /**
     * Determine if the mention goes to a post
     */
    public function isPost(): bool
    {
        return !empty($this->post_id);
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
                    return $subEnt
                        // @phpstan-ignore-next-line
                        ->entity()
                        ->has('entity');
                })
                ->orWhere(function ($subPost) {
                    return $subPost
                        // @phpstan-ignore-next-line
                        ->post()
                        ->has('post.entity');
                });
        });
    }
    /**
     */
    public function scopeEntity(Builder $query): Builder
    {
        return $query->whereNotNull('image_mentions.entity_id');
    }

    /**
     */
    public function scopePost(Builder $query): Builder
    {
        return $query->whereNotNull('image_mentions.post_id');
    }
}
