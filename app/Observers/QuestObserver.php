<?php

namespace App\Observers;

use App\Campaign;
use App\Models\MiscModel;
use App\Models\Quest;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class QuestObserver extends MiscObserver
{
    /**
     * @param Quest $quest
     */
    public function deleting(MiscModel $quest)
    {
        parent::deleting($quest);
        $quest->locations()->delete();
        $quest->characters()->delete();
    }
}
