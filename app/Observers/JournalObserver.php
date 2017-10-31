<?php

namespace App\Observers;

use App\Campaign;
use App\Journal;
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

        if (request()->has('image')) {
            $path = request()->file('image')->store('journals', 'public');
            if (!empty($path)) {
                // Remove old
                $original = $journal->getOriginal('image');
                if (!empty($original)) {
                    // Delete
                    Storage::disk('public')->delete($original);
                }
                $journal->image = $path;
            }
        }
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
        if (!empty($journal->image)) {
            // Delete
            Storage::disk('public')->delete($journal->image);
        }
    }

    /**
     * @param Journal $journal
     */
    public function deleting(Journal $journal)
    {

    }
}
