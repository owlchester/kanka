<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Quest;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class QuestObserver extends MiscObserver
{
    /**
     * @param Quest $quest
     */
    public function deleting(Quest $quest)
    {
        $quest->locations()->delete();
        $quest->characters()->delete();
    }
}
