<?php

namespace App\Policies;

use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\Quest;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.quest');
    }
}
