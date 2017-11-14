<?php

namespace App\Policies;

use App\User;
use App\Journal;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function view(User $user, Journal $journal)
    {
        return $user->campaign->id == $journal->campaign_id &&
            ($journal->is_private ? !$user->viewer() : true);
    }

    /**
     * Determine whether the user can create journals.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function update(User $user, Journal $journal)
    {
        return $user->campaign->id == $journal->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the journal.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function delete(User $user, Journal $journal)
    {
        return $user->campaign->id == $journal->campaign_id &&
            ($user->member());
    }
}
