<?php

namespace App\Policies;

use App\User;
use App\Models\Organisation;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganisationPolicy extends MiscPolicy
{
    protected $model = 'organisation';

    public function member(User $user, Organisation $organisation)
    {
        return $this->relatedElement($user, $organisation, '');
    }
}
