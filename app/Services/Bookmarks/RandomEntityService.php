<?php

namespace App\Services\Bookmarks;

use App\Facades\Dashboard;
use App\Models\Bookmark;
use App\Models\Entity;

class RandomEntityService
{
    protected Bookmark $bookmark;

    public function bookmark(Bookmark $bookmark): self
    {
        $this->bookmark = $bookmark;

        return $this;
    }

    public function url(): ?string
    {
        $entityType = $this->bookmark->random_entity_type != 'any' ? $this->bookmark->random_entity_type : null;
        $entityTypeID = null;
        if (! empty($entityType)) {
            $entityTypeID = config('entities.ids.' . $entityType);
        }

        /** @var ?Entity $entity */
        $entity = Entity::inTags($this->bookmark->tags->pluck('id')->toArray())
            ->inTypes($entityTypeID)
            ->whereNotIn('entities.id', Dashboard::excluding())
            ->inRandomOrder()
            ->first();

        if (empty($entity) || $entity->isMissingChild()) {
            return null;
        }

        return $entity->url();
    }
}
