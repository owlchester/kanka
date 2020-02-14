<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Post;

/**
 * Class Release
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $excerpt
 * @property string $image
 * @property User $author
 */
class Release extends Post
{
    // Do nothing, this class is just for the route resource binding to work with release instead of post.

    public $table = 'posts';

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->id . '-' . Str::slug($this->title);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
