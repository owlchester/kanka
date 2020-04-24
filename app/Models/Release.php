<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
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
class Release extends Post implements Feedable
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
     * RSS feed item
     * @return FeedItem
     */
    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary((string) $this->excerpt)
            ->updated($this->updated_at)
            ->link($this->link)
            ->author('Kanka.io');
    }

    /**
     * link attribute
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('front.news.show', $this->getSlug());
    }

    /**
     * RSS items
     * @return mixed
     */
    public function getFeedItems()
    {
        return Release::published()
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
