<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PostTag
 *
 * @property int $post_id
 * @property int $tag_id
 * @property Tag $tag
 * @property Post $post
 */
class PostTag extends Model
{
    use HasFactory;

    public $table = 'post_tag';

    protected $fillable = [
        'post_id',
        'tag_id',
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

    public function exportFields(): array
    {
        return [
            'tag_id',
        ];
    }
}
