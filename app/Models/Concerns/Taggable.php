<?php


namespace App\Models\Concerns;


use App\Models\Tag;
use App\Observers\TaggableObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait Taggable
 * @package App\Models\Concerns
 *
 * @property Model[]|Tag[] $tags
 */
trait Taggable
{
    public static function bootTaggable(): void
    {
        // Don't add this observer if in console mode
        if (app()->runningInConsole()) {
            return;
        }
        static::observe(app(TaggableObserver::class));
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
