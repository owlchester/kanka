<?php

namespace App\Policies;

use App\Campaign;
use App\User;
use App\Models\Character;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiceRollResultPolicy extends EntityPolicy
{
    /**
     * @var string
     */
    protected $model = 'dice_roll';

    public function update(User $user, $entity)
    {
        return false;
    }

    public function delete(User $user, $entity)
    {
        return false;
    }

    public function view(User $user, $entity)
    {
        return true;
    }

    public function create(User $user, $entity = null, Campaign $campaign = null)
    {
        return false;
    }
}
