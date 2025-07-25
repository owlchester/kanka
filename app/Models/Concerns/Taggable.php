<?php

namespace App\Models\Concerns;

use App\Models\Tag;
use App\Observers\TaggableObserver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Trait Taggable
 *
 * @property Tag[]|Collection $tags
 * @property Tag[]|Collection $visibleTags
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, $this->getTagPivotTableName())
            ->with('entity')
            ->has('entity');
    }

    protected function getTagPivotTableName(): ?string
    {
        if (property_exists($this, 'tagPivotName')) {
            return $this->tagPivotName;
        }

        return null;
    }

    public function visibleTags(): BelongsToMany
    {
        return $this->tags()
            ->onlyVisible();
    }
}
