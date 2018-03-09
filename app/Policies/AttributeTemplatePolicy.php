<?php

namespace App\Policies;

use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\AttributeTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributeTemplatePolicy
{
    use HandlesAuthorization;
    use AdminPolicyTrait;

    /**
     * Determine whether the user can view the attributeTemplate.
     *
     * @param  \App\User  $user
     * @param  \App\Models\AttributeTemplate  $attributeTemplate
     * @return mixed
     */
    public function browse(User $user)
    {
        return $this->create($user);
    }

    /**
     * Determine whether the user can view the attributeTemplate.
     *
     * @param  \App\User  $user
     * @param  \App\Models\AttributeTemplate  $attributeTemplate
     * @return mixed
     */
    public function view(User $user, AttributeTemplate $attributeTemplate)
    {
        return $user->campaign->id == $attributeTemplate->campaign_id && $this->isAdmin($user);
    }

    /**
     * Determine whether the user can create attributeTemplates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the attributeTemplate.
     *
     * @param  \App\User  $user
     * @param  \App\Models\AttributeTemplate  $attributeTemplate
     * @return mixed
     */
    public function update(User $user, AttributeTemplate $attributeTemplate)
    {
        return $user->campaign->id == $attributeTemplate->campaign_id &&
            $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the attributeTemplate.
     *
     * @param  \App\User  $user
     * @param  \App\Models\AttributeTemplate  $attributeTemplate
     * @return mixed
     */
    public function delete(User $user, AttributeTemplate $attributeTemplate)
    {
        return $user->campaign->id == $attributeTemplate->campaign_id &&
            $this->isAdmin($user);
    }
}
