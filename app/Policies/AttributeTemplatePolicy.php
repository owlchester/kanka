<?php

namespace App\Policies;

use App\Models\CampaignPermission;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\AttributeTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributeTemplatePolicy
{
    use HandlesAuthorization;
    use AdminPolicyTrait;

    /**
     * Model for permissions lookup
     * @var string
     */
    protected $model = 'attribute_template';

    /**
     * Caching the permissions check
     * @var array
     */
    protected static $cached = [];

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
     * @param User $user
     * @return mixed
     */
    public function attribute(User $user, $entity, $subAction = 'browse')
    {
        return $this->update($user, $entity);
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
        return $user->campaign->id == $attributeTemplate->campaign_id &&
            $this->checkPermission('browse', $user);
    }

    /**
     * Determine whether the user can create attributeTemplates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return
            $this->checkPermission('add', $user);
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
            $this->checkPermission('edit', $user);
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
            $this->checkPermission('delete', $user);
    }

    /**
     * @param string $action
     * @param User $user
     * @param Entity|null $entity
     * @return bool
     */
    protected function checkPermission($action, User $user, $entity = null)
    {
        $key = $this->model . '_' . $action;
        if (isset(self::$cached[$key])) {
            return self::$cached[$key];
        }

        // Want to get my user's permissions and roles
        $keys = [$key];
        // If we've specified an entity, it could be that our role or user has permissions on it
        if (!empty($entity)) {
            $keys[] = $this->model . '_' . $action . '_' . $entity->id;
        }

        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        $roleIds = [];
        foreach ($user->campaignRoles as $role) {
            if ($role->is_admin) {
                return true;
            }
            $roleIds[] = $role->id;
        }

        // Check for a permission related to this action.
        $value = CampaignPermission::whereIn('key', $keys)
                ->where(function ($query) use ($user, $roleIds) {
                    return $query->where(['user_id' => $user->id])->orWhereIn('campaign_role_id', $roleIds);
                })->count() > 0;

        // Cache the result
        self::$cached[$key] = $value;

        return $value;
    }
}
