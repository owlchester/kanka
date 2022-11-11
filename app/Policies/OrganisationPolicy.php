<?php

namespace App\Policies;

use App\User;
use App\Models\Organisation;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganisationPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.organisation');
    }

    public function member(User $user, Organisation $organisation)
    {
        return $this->relatedElement($user, $organisation, '');
    }
}
