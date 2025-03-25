<?php

namespace App\Policies;

use App\Models\Organisation;
use App\Models\User;

class OrganisationPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.organisation');
    }

    public function member(User $user, Organisation $organisation)
    {
        return $user->can('update', $organisation->entity);
    }
}
