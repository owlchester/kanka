<?php

namespace App\Observers;

use App\Models\CommunityEvent;
use App\Services\ImageService;
use Illuminate\Support\Str;

class CommunityEventObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param CommunityEvent $communityEvent
     */
    public function saving(CommunityEvent $communityEvent)
    {
        $communityEvent->entry = $this->purify($communityEvent->entry);

        // Handle image. Let's use a service for this.
        ImageService::handle($communityEvent, $communityEvent->getTable());
    }
}
