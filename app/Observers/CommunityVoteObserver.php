<?php

namespace App\Observers;

use App\Models\CommunityVote;

class CommunityVoteObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param CommunityVote $communityVote
     */
    public function saving(CommunityVote $communityVote)
    {
        $communityVote->content = $this->purify($communityVote->content);
    }
}
