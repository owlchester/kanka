<?php

namespace App\Policies;

use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\Quest;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestPolicy extends EntityPolicy
{
    protected $model = 'quest';

    public function character(User $user, Quest $quest)
    {
        return $this->relatedElement($user, $quest, '');
    }

    public function location(User $user, Quest $quest)
    {
        return $this->relatedElement($user, $quest, '');
    }
}
