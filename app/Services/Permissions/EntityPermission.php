<?php

namespace App\Services\Permissions;

use App\Enums\Permission;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\User;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\EntityTypeAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;

class EntityPermission
{
    use UserAware;
    use EntityAware;
    use EntityTypeAware;
    use CampaignAware;

    protected array $cached = [];

    protected array|bool $roleIds;

    /**
     * The roles of the user
     */
    protected array|bool|Collection $roles = [];

    protected array $cachedEntityIds = [];

    /**
     * @var bool is admin
     */
    protected $userIsAdmin = null;

    /**
     * Permissions were loaded
     */
    protected bool $loadedAll = false;

    /**
     * Campaign id of the loaded permissions (required for when moving entities between campaigns)
     */
    protected int $loadedCampaignId = 0;

    public function can(Permission $permission): bool
    {
        $this->loadAllPermissions($this->user, $this->campaign);
        if ($this->userIsAdmin) {
            return true;
        }

        // Check general module permissions
        $module = isset($this->entityType) ? $this->entityType->id : $this->entity->type_id;
        $key = '' . $module . '_' . $permission->value;
        $perm = false;
        if (isset($this->cached[$key]) && $this->cached[$key]) {
            $perm = $this->cached[$key];
        }

//        dump('module permission');
//        dump($key);
//        dump($this->cached);
        if (!isset($this->entity)) {
//            dd('no entity');
            return $perm;
        }

        // Search for entity
        $entityKey = '_' . $permission->value . '_' . $this->entity->id;
//        dump('check entity');
//        dd($entityKey);
        if (isset($this->cached[$entityKey])) {
            return $this->cached[$entityKey];
        }
        return $perm;
    }

    /**
     * Determine the permission for a user to interact with an entity
     * @param MiscModel|Entity|null $entity
     */
    public function hasPermission(
        int $entityType,
        int $action,
        User $user = null,
        $entity = null,
        Campaign $campaign = null
    ): bool {
        $this->loadAllPermissions($user, $campaign);

        if ($this->userIsAdmin) {
            return true;
        }

        // Check if we have permission to `action` all the entities of this type first. The user
        // might be able to view all quests, but have a specific quest set to denied. This is why
        // we need to check the specific permissions too.
        if ($entityType === 0) {
            // Campaign permissions are a bit funky
            $entityType = 'campaign';
        }
        $key = $entityType . '_' . $action;

//        if ($action === 1) {
//            dump($key = $entityType . '_' . $action);
//            dump($this->cached);
//        }

        $perm = false;
        if (isset($this->cached[$key]) && $this->cached[$key]) {
            $perm = $this->cached[$key];
        }

        // Check if we have permission to do this action for exactly this entity
        if (!empty($entity)) {
//            dump('i have an entity?');
//            dump($entity);

            //Check if $entity is an entity type.
            if (isset($entity->type_id)) {
                dump('entity object');
                $entityKey = '_' . $action . '_' . $entity->entity_id;
            } else {
                //dump('misc object');
                $entityKey = '_' . $action . '_' . $entity->id;
            }
//            dump('entity key ' . $entityKey);
            if (isset($this->cached[$entityKey])) {
                $perm = $this->cached[$entityKey];
            }
        }

        //dump('have access? ' . ($perm ? 'yes' : 'no'));
        return $perm;
    }

    /**
     * Check the roles of the user. If the user is an admin, always return true
     */
    protected function getRoleIds(Campaign $campaign, ?User $user = null): array|bool
    {
        // If we haven't built a list of roles yet, build it.
        if (isset($this->roleIds)) {
            return $this->roleIds;
        }

        $this->roles = false;
        // If we have a user, get the user's role for this campaign
        if ($user) {
            $this->roles = UserCache::user($user)->campaign($campaign)->roles();
        }

        // If we don't have a user, or our user has no specified role yet, use the public role.
        if ($this->roles === false || $this->roles->count() == 0) {
            // Use the campaign's public role
            $this->roles = $campaign->roles()->where('is_public', true)->get();
        }

        // Save all the role ids. If one of them is an admin, stop there.
        $this->roleIds = [];
        foreach ($this->roles as $role) {
            if ($role['is_admin']) {
                $this->roleIds = true;
                return true;
            }
            $this->roleIds[] = $role['id'];
        }
        return $this->roleIds;
    }

    /**
     * Determine if a user is part of a role that can do an action on all entities of a campaign
     */
    public function canRole(string $action, string $modelName, ?User $user = null, ?Campaign $campaign = null): bool
    {
        $this->loadAllPermissions($user, $campaign);
        $key = $modelName . '_' . $action;

        // We check if the role was set for global entity permissions
        if (isset($this->cached[$key]) && $this->cached[$key]) {
            return $this->cached[$key];
        }

        return false;
    }

    /**
     * It's way easier to just load all permissions of the user once and "cache" them, rather than try and be
     * optional on each query.
     */
    protected function loadAllPermissions(?User $user = null, ?Campaign $campaign = null): void
    {
        // If no campaign was provided, get the one in the url. One is provided when moving entities between campaigns
        if (empty($campaign)) {
            $campaign = \App\Facades\CampaignLocalization::getCampaign();

            // Our Campaign middleware takes care of this, but the laravel binding is going to get the model first,
            // so we have to add this abort here to handle calling the permission engine on campaigns which
            // no longer exist.
            if (empty($campaign)) {
                // Before we do that, we need to check if we're in a factory for unit tests
                if (app()->environment('testing')) {
                    $this->userIsAdmin = true;
                    return;
                } else {
                    abort(404);
                }
            }
        }

        if ($this->loadedAll === true && $campaign->id == $this->loadedCampaignId) {
            return;
        }

        $this->resetPermissions();
        $this->loadedCampaignId = $campaign->id;

        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        unset($this->roleIds);
        $roleIds = $this->getRoleIds($campaign, $user);
        if ($roleIds === true) {
            // If the role ids is simply true, it means the user is an admin
            $this->userIsAdmin = true;
            return;
        }

        $campaignRoleIDs = [];
        /** @var CampaignRole $role */
        foreach ($this->roles as $role) {
            $campaignRoleIDs[] = $role['id'];
        }
        //dump('roles');
        if (!empty($campaignRoleIDs)) {
            $permissions = \App\Facades\RolePermission::rolesPermissions($campaignRoleIDs);
            /** @var CampaignPermission $permission */
            foreach ($permissions as $permission) {
                //dump($permission->id . ' - ' . $permission->key());
                $this->cached[$permission->key()] = $permission->access;
                if (!empty($permission->entity_id)) {
                    $this->cachedEntityIds[$permission->entity_type_id][$permission->entity_id][$permission->action] = (bool) $permission->access;
                }
            }
        }

        // If a user is provided, get their permissions too
        //dump('user');
        if (!empty($user)) {
            $userPermissions = $user->permissions()->where('campaign_id', $campaign->id)->get();
            /** @var CampaignPermission $permission */
            foreach ($userPermissions as $permission) {
                $this->cached[$permission->key()] = $permission->access;
                //dump($permission->id . ' - ' . $permission->key());
                if (!empty($permission->entity_id)) {
                    $this->cachedEntityIds[$permission->entity_type_id][$permission->entity_id][$permission->action] = (bool) $permission->access;
                }
            }
            unset($userPermissions);
        }

        //dump('finished loading entities:');
        //dump($this->cachedEntityIds);
    }

    /**
     * Reset all cached permissions.
     */
    public function resetPermissions(): void
    {
        // Reset the values keeping score
        $this->loadedAll = true;
        $this->cached = [];
        unset($this->roleIds);
        $this->userIsAdmin = false;
    }
}
