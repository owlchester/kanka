<?php

namespace App\Observers;

use App\Models\EntityLink;

class EntityLinkObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     */
    public function saving(EntityLink $entityLink)
    {
        $entityLink->name = $this->purify($entityLink->name);
        $entityLink->url = $this->purify($entityLink->url);
        $entityLink->icon = $this->purify($entityLink->icon);

        if (!empty($entityLink->position)) {
            $entityLink->position = (int) $entityLink->position;
        } else {
            /** @var EntityLink|null $lastLink */
            $lastLink = $entityLink->entity->links()->sortByDesc('position')->first();
            if ($lastLink) {
                $entityLink->position = (int) $lastLink->position + 1;
            } else {
                $entityLink->position = 1;
            }
        }
    }

    /**
     */
    public function creating(EntityLink $entityLink)
    {
        $entityLink->created_by = auth()->user()->id;
    }
}
