<?php

namespace App\Policies;

use App\User;
use App\Models\Quest;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the quest.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Quest  $quest
     * @return mixed
     */
    public function view(User $user, Quest $quest)
    {
        return $user->campaign->id == $quest->campaign_id &&
            ($quest->is_private ? !$user->viewer() : true);
    }

    /**
     * Determine whether the user can create quests.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the quest.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Quest  $quest
     * @return mixed
     */
    public function update(User $user, Quest $quest)
    {
        return $user->campaign->id == $quest->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the quest.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Quest  $quest
     * @return mixed
     */
    public function delete(User $user, Quest $quest)
    {
        return $user->campaign->id == $quest->campaign_id &&
            ($user->member());
    }
    /**
     * Determine if a model can be moved to another type.
     *
     * @param User $user
     * @param Quest $quest
     * @return mixed
     */
    public function move(User $user, Quest $quest)
    {
        return $this->update($user, $quest);
    }
}
