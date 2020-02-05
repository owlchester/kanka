<?php

namespace App\Observers;

use App\Models\CommunityVote;

class CommunityVoteObserver
{
    /**
     * @param CommunityVote $communityVote
     */
    public function saving(CommunityVote $communityVote)
    {
    }
}
