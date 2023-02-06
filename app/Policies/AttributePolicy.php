<?php

namespace App\Policies;

use App\User;
use App\Models\Attribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributePolicy
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
     * Determine whether the user can view the characterAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Attribute  $attribute
     * @return bool
     */
    public function view(User $user, Attribute $attribute)
    {
        return $user->campaign->id == $attribute->entity->campaign_id;
    }
}
