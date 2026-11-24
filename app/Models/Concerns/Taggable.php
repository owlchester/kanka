<?php

namespace App\Models\Concerns;

use App\Models\Tag;
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
    /**
     * @return BelongsToMany<Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, $this->getTagPivotTableName())
            ->with(['entity' => function ($query) {
                $query->select('entities.id', 'entities.name', 'entities.entity_id', 'entities.child_type', 'entities.type_id');
            }])
            ->has('entity');
    }

    protected function getTagPivotTableName(): ?string
    {
        if (property_exists($this, 'tagPivotName')) {
            return $this->tagPivotName;
        }

        return null;
    }

    public function visibleTags(): \Illuminate\Support\Collection
    {
        return $this->tags
            ->where('is_hidden', 0);
    }
}
