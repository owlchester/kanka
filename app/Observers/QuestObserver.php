<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Quest;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class QuestObserver
{
    /**
     * @var LinkerService
     */
    protected $linkerService;

    /**
     * CharacterObserver constructor.
     * @param LinkerService $linkerService
     */
    public function __construct(LinkerService $linkerService)
    {
        $this->linkerService = $linkerService;
    }

    /**
     * @param Quest $quest
     */
    public function saving(Quest $quest)
    {
        $quest->slug = str_slug($quest->name, '');
        $quest->campaign_id = Session::get('campaign_id');

        $quest->description = Purify::clean($quest->description);
        $quest->description = $this->linkerService->parse($quest->description);

        // Handle image. Let's use a service for this.
        ImageService::handle($quest, 'journals');
    }

    /**
     * @param Quest $quest
     */
    public function saved(Quest $quest)
    {
    }

    /**
     * @param Quest $quest
     */
    public function created(Quest $quest)
    {
    }

    /**
     * @param Quest $quest
     */
    public function deleted(Quest $quest)
    {
        ImageService::cleanup($quest);
    }

    /**
     * @param Quest $quest
     */
    public function deleting(Quest $quest)
    {
        $quest->locations()->delete();
        $quest->characters()->delete();
    }
}
