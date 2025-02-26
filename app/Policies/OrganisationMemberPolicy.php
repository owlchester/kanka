<?php

namespace App\Policies;

use App\Models\OrganisationMember;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganisationMemberPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    /**
     * Determine whether the user can update the entity.
     *
     */
    public function update(User $user, OrganisationMember $entity)
    {
        if (auth()->guest()) {
            return false;
        }
        return auth()->user()->can('update', $entity->organisation->entity) ||
            auth()->user()->can('update', $entity->character->entity);
    }


    /**
     * Determine whether the user can update the entity.
     *
     */
    public function delete(User $user, OrganisationMember $entity)
    {
        if (auth()->guest()) {
            return false;
        }
        return auth()->user()->can('delete', $entity->organisation->entity) ||
            auth()->user()->can('delete', $entity->character->entity);
    }
}
