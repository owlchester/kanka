<?php

namespace App\Observers;

use App\Campaign;
use App\Journal;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class JournalObserver
{
    /**
     * @param Journal $journal
     */
    public function saving(Journal $journal)
    {
        $journal->slug = str_slug($journal->name, '');
        $journal->campaign_id = Session::get('campaign_id');

        $journal->history = Purify::clean($journal->history);

        $journal->history = preg_replace(
            '`\{character:(.*?)\}`sui',
            '<a href="/redirect?what=character&name=$1">$1</a>',
            $journal->history
        );
        $journal->history = preg_replace(
            '`\{item:(.*?)\}`sui',
            '<a href="/redirect?what=items&name=$1">$1</a>',
            $journal->history
        );
        $journal->history = preg_replace(
            '`\{location:(.*?)\}`sui',
            '<a href="/redirect?what=locations&name=$1">$1</a>',
            $journal->history
        );
        $journal->history = preg_replace(
            '`\{(organisation|organization):(.*?)\}`sui',
            '<a href="/redirect?what=organisation&name=$2">$2</a>',
            $journal->history
        );
        $journal->history = preg_replace(
            '`\{family:(.*?)\}`sui',
            '<a href="/redirect?what=families&name=$1">$1</a>',
            $journal->history
        );

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
