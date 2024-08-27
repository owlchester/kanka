<?php

/**
 * Description of
 *
 * 05/02/2020
 */

namespace App\Policies;

use App\Models\CommunityVote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommunityVotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if a user can view a vote
     */
    public function show(?User $user, CommunityVote $communityVote): bool
    {
        $status = $communityVote->status();
        if ($status == CommunityVote::STATUS_PUBLISHED) {
            return true;
        }
        // If it's not published and we aren't logged in, nope nope nope
        if (empty($user)) {
            return false;
        }

        if ($status == CommunityVote::STATUS_VOTING) {
            return $user->isGoblin() || $user->hasRole('admin');
        }

        // Scheduled and Draft are limited to admins
        return $user->hasRole('admin');
    }

    /**
     * Determine if a user can participate in a vote
     */
    public function vote(User $user, CommunityVote $communityVote): bool
    {
        $status = $communityVote->status();
        if ($status == CommunityVote::STATUS_PUBLISHED) {
            return true;
        } elseif ($status == CommunityVote::STATUS_VOTING) {
            return $user->isGoblin();
        }

        // Not in a voting phase
        return false;
    }
}
