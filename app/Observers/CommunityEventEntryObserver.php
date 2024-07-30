<?php

namespace App\Observers;

use App\Models\CommunityEventEntry;

class CommunityEventEntryObserver
{
    /**
     */
    public function creating(CommunityEventEntry $communityEventEntry)
    {
        $communityEventEntry->created_by = auth()->user()->id;
    }
}
