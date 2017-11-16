<?php

namespace App\Observers;

use App\Campaign;
use App\Journal;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class JournalObserver
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
     * @param Journal $journal
     */
    public function saving(Journal $journal)
    {
        $journal->slug = str_slug($journal->name, '');
        $journal->campaign_id = Session::get('campaign_id');

        $journal->history = Purify::clean($journal->history);
        $journal->history = $this->linkerService->parse($journal->history);

        // Handle image. Let's use a service for this.
        ImageService::handle($journal, 'journals');
    }

    /**
     * @param Journal $journal
     */
    public function saved(Journal $journal)
    {
    }

    /**
     * @param Journal $journal
     */
    public function created(Journal $journal)
    {
    }

    /**
     * @param Journal $journal
     */
    public function deleted(Journal $journal)
    {
        ImageService::cleanup($journal);
    }

    /**
     * @param Journal $journal
     */
    public function deleting(Journal $journal)
    {

    }
}
