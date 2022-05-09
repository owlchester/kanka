<?php
/**
 * Description of
 *
 * 05/02/2020
 */

namespace App\Policies;

use App\Models\CommunityVote;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommunityVotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if a user can view a vote
     * @param User $user
     * @param CommunityVote $communityVote
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
            return $user->isGoblin();
        }

        // Scheduled and Draft are limited to admins
        return $user->hasRole('admin');
    }

    /**
     * Determine if a user can participate in a vote
     * @param User $user
     * @param CommunityVote $communityVote
     * @return bool
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
