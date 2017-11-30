<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Note;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class NoteObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

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
        $note->description = $this->purify($note->description);
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
