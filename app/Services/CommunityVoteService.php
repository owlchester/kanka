<?php


namespace App\Services;


use App\Models\CommunityVote;
use App\Models\CommunityVoteBallot;
use App\User;

class CommunityVoteService
{
    /**
     * @param CommunityVote $communityVote
     * @param User $user
     * @param string|null $option
     * @return array
     */
    public function cast(CommunityVote $communityVote, User $user, string $option = null): array
    {
        if (empty($option)) {
            $this->remove($communityVote, $user);
        } else {
            $this->add($communityVote, $user, $option);
        }

        // Return the new % values
        $communityVote->refresh();
        return $communityVote->voteStats();
    }

    /**
     * @param CommunityVote $communityVote
     * @param User $user
     */
    protected function remove(CommunityVote $communityVote, User $user): void
    {
        CommunityVoteBallot::where([
            'community_vote_id' => $communityVote->id,
            'user_id' => $user->id,
        ])->delete();
    }

    /**
     * @param CommunityVote $communityVote
     * @param User $user
     * @param string $option
     */
    protected function add(CommunityVote $communityVote, User $user, string $option): void
    {
        // Validate the option
        $options = $communityVote->options();
        if (!isset($options[$option])) {
            return;
        }

        // If we've already voted for this option, don't bother
        if ($communityVote->votedFor($option)) {
            return;
        }

        // Delete any previous option
        $this->remove($communityVote, $user);

        CommunityVoteBallot::create([
            'community_vote_id' => $communityVote->id,
            'user_id' => $user->id,
            'vote' => $option,
        ]);
    }
}
