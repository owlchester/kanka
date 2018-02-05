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
        //
    }

    /**
     * Determine whether the user can view the characterAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Attribute  $characterAttribute
     * @return mixed
     */
    public function view(User $user, Attribute $attribute)
    {
        return $user->campaign->id == $attribute->entity->campaign_id;
    }

    /**
     * Determine whether the user can create characterAttributes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the characterAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Attribute  $attribute
     * @return mixed
     */
    public function update(User $user, Attribute $attribute)
    {
        return $user->campaign->id == $attribute->entity->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the characterAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Attribute  $attribute
     * @return mixed
     */
    public function delete(User $user, Attribute  $attribute)
    {
        return $user->campaign->id == $attribute->entity->campaign_id &&
            ($user->member());
    }
}
