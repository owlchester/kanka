<?php

namespace App\Observers;

use App\Models\Event;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;
use Stevebauman\Purify\Facades\Purify;

class EventObserver
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
     * @param Event $event
     */
    public function saving(Event $event)
    {
        $event->slug = str_slug($event->name, '');
        $event->campaign_id = Session::get('campaign_id');

        // Purity text
        $event->history = Purify::clean($event->history);

        // Parse links
        $event->history = $this->linkerService->parse($event->history);

        // Handle image. Let's use a service for this.
        ImageService::handle($event, 'events');
    }

    /**
     * @param Event $event
     */
    public function saved(Event $event)
    {
    }

    /**
     * @param Event $event
     */
    public function created(Event $event)
    {
    }

    /**
     * @param Event $event
     */
    public function deleted(Event $event)
    {
        ImageService::cleanup($event);
    }

    /**
     * @param Event $event
     */
    public function deleting(Event $event)
    {
    }
}
