<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
class Release extends Model
{
    // Do nothing, this class is just for the route resource binding to work with release instead of post.

    public $table = 'posts';

    /**
     * @return array
     */
    public function getSlug(): array
    {
        return [
            'id' => $this->id,
            'slug' => Str::slug($this->title)
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * link attribute
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('front.news.show', $this->getSlug());
    }
}
