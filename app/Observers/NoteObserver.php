<?php

namespace App\Observers;

use App\Campaign;
use App\Note;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class NoteObserver
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
     * @param Note $note
     */
    public function saving(Note $note)
    {
        $note->slug = str_slug($note->name, '');
        $note->campaign_id = Session::get('campaign_id');

        // Purity text
        $note->description = Purify::clean($note->description);
        $note->description = $this->linkerService->parse($note->description);

        // Handle image. Let's use a service for this.
        ImageService::handle($note, 'notes');
    }

    /**
     * @param Character $character
     */
    public function deleted(Note $note)
    {
        ImageService::cleanup($note);
    }
}
