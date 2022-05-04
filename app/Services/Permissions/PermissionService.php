<?php

namespace App\Services\Permissions;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Models\EntityNotePermission;
use App\User;
use Illuminate\Support\Str;

class PermissionService
{
    /** @var Campaign */
    protected $campaign;

    /** @var User */
    protected $user;

    /** @var int CampaignPermission::ACTION_READ etc */
    protected $action;

    /** @var array Entity IDs and Types the user can access */
    protected $entityIds = [];
    protected $entityTypes = [];
    protected $entityTypesIds = [];
    protected $deniedIds = [];
    protected $allowedModels = [];
    protected $deniedModels = [];
    protected $loadedPermissions = false;

    /** @var array Permissions for posts */
    protected $allowedPostIDs = [];
    protected $deniedPostIDs = [];
    protected $loadedPosts = false;

    protected $loadedRoles = false;
    protected $admin = false;

    protected $granted = false;

    /** @var null|string the entity type if provided to limit queries */
    protected $entityType = null;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function isAdmin(): bool
    {
        $this->loadPermissions();
        return $this->admin;
    }

    /**
     * Set the desired action
     * @param int $action
     * @return $this
     */
    public function action(int $action): self
    {
        $this->action = $action;
        return $this;
    }

    public function reload(): self
    {
        $this->entityIds = [];
        $this->entityTypes = [];
        $this->entityTypesIds = [];
        $this->deniedIds = [];
        $this->loadedRoles = false;
        $this->admin = false;
        return $this;
    }

    public function entityType(int $entityType): self
    {
        $this->entityType = $entityType;
        return $this;
    }

    /**
     * List of post ids the user has access to
     * @return array
     */
    public function allowedPosts(): array
    {
        return $this->loadPostPermissions()
            ->allowedPostIDs();
    }

    /**
     * List of post ids the user doesn't have access to
     * @return array
     */
    public function deniedPosts(): array
    {
        return $this->loadPostPermissions()
            ->deniedPostIDs();
    }

    public function allowedEntities(): array
    {
        $this->loadPermissions();
        return $this->entityIds;
    }

    public function allowedEntityTypes(): array
    {
        $this->loadPermissions();
        return $this->entityTypesIds;
    }

    public function deniedEntities(): array
    {
        $this->loadPermissions();
        return $this->deniedIds;
    }

    protected function allowedPostIDs(): array
    {
        return $this->allowedPostIDs;
    }

    protected function deniedPostIDs(): array
    {
        return $this->deniedPostIDs;
    }

    public function allowedModels(): array
    {
        $this->loadPermissions();
        return $this->allowedModels;
    }

    public function deniedModels(): array
    {
        $this->loadPermissions();
        return $this->deniedModels;
    }

    public function canRole(): bool
    {
        $this->loadPermissions();
        return in_array($this->entityType, $this->entityTypesIds);
    }

    /**
     * Grant a permission ad-hoc
     * @param Entity $entity
     * @param string $action
     * @return $this
     */
    public function grant(Entity $entity): self
    {
        $this->granted = true;
        $this->entityIds[] = $entity->id;
        $this->allowedModels[] = $entity->entity_id;
        return $this;
    }

    /**
     * Was a permission granted?
     * @return bool
     */
    public function granted(): bool
    {
        return $this->granted;
    }

    /**
     * Load the permissions for posts (entity notes)
     * @return $this
     */
    protected function loadPostPermissions(): self
    {
        if ($this->loadedPosts) {
            return $this;
        }
        $this->loadedPosts = true;

        /** @var EntityNotePermission $perm */
        $perms = EntityNotePermission::select(['entity_note_id', 'permission'])
            ->where('user_id', $this->user->id)
            ->get();
        foreach ($perms as $perm) {
            if ($perm->permission === 2) {
                $this->deniedPostIDs[] = $perm->entity_note_id;
            } else {
                $this->allowedPostIDs[] = $perm->entity_note_id;
            }
        }

        // User roles
        $roles = $this->user->campaignRoleIDs($this->campaign->id);
        $perms = EntityNotePermission::select(['entity_note_id', 'permission'])
            ->whereIn('role_id', $roles)
            ->get();
        foreach ($perms as $perm) {
            if ($perm->permission === 2) {
                $this->deniedPostIDs[] = $perm->entity_note_id;
            } else {
                $this->allowedPostIDs[] = $perm->entity_note_id;
            }
        }

        return $this;
    }

    /**
     * Load the permissions of the user (roles and personal permissions)
     * @return bool
     */
    private function loadPermissions(): self
    {
        if ($this->loadedPermissions) {
            return $this;
        }
        $this->loadedPermissions = true;

        // Valid user: load their roles
        if ($this->user) {
            $this->loadRoles();
            $this->loadUserPermissions();
        }

        // If the user had no loaded roles, we need a public role
        if ($this->loadedRoles > 0) {
            return $this;
        }
        $this->loadPublicRole();

        return $this;
    }

    /**
     * Load the user's roles
     * @return $this
     */
    protected function loadRoles(): self
    {
        if ($this->loadedRoles !== false) {
            return $this;
        }
        $this->loadedRoles = 0;

        $roles = UserCache::user($this->user)->roles()->where('campaign_id', $this->campaign->id);
        $roleIDs = [];
        foreach ($roles as $role) {
            $this->loadedRoles++;
            // If one of the roles is an admin, we don't need to figure any more stuff, we're good.
            if ($role->is_admin) {
                $this->admin = true;
                return $this;
            }
            $roleIDs[] = $role->id;
        }
        $this->parseRoles($roleIDs);


        return $this;
    }

    /**
     * Load public role permissions as a fall back for non-members of the campaign.
     */
    protected function loadPublicRole(): void
    {
        // Go and get the Public role from the cache.
        $publicRole = CampaignCache::campaign($this->campaign)
            ->roles()
            ->where('is_public', true)
            ->first();
        if ($publicRole) {
            $this->parseRole($publicRole);
        }
    }

    /**
     * Load the permissions of a role into the service
     * @param CampaignRole $role
     */
    protected function parseRole(CampaignRole $role): void
    {
        // Loop through the permissions of the role to get any blanket _read permissions on entities
        $permissions = \App\Facades\RolePermission::role($role)->permissions();
        foreach ($permissions as $permission) {
            $this->parseRolePermission($permission);
        }
    }
    /**
     * Load the permissions of several roles into the service
     * @param array $roleIDs
     */
    protected function parseRoles(array $roleIDs): void
    {
        // Loop through the permissions of the role to get any blanket _read permissions on entities
        $permissions =
        $permissions = \App\Facades\RolePermission::rolesPermissions($roleIDs);
        //CampaignPermission::whereIn('campaign_role_id', $roleIDs)->get();
        foreach ($permissions as $permission) {
            $this->parseRolePermission($permission);
        }
    }

    /**
     * Parse a role permission
     * @param CampaignPermission $permission
     */
    protected function parseRolePermission(CampaignPermission $permission)
    {
        // Only test permissions who's action is being requested
        if (!$permission->isAction($this->action)) {
            return;
        }
        if (!empty($this->entityType) && $permission->entity_type_id !== $this->entityType) {
            return;
        }

        if (empty($permission->entity_id)) {
            if (!in_array($permission->entity_type_id, $this->entityTypesIds)) {
                $this->entityTypesIds[] = $permission->entity_type_id;
            }
        } elseif ($permission->access && !in_array($permission->entity_id, $this->entityIds)) {
            // This permission targets an entity directly
            $this->entityIds[] = $permission->entity_id;
            $this->allowedModels[] = $permission->misc_id;
        } elseif (!$permission->access && !in_array($permission->entity_id, $this->deniedIds)) {
            // This permission targets an entity directly
            $this->deniedIds[] = $permission->entity_id;
            $this->deniedModels[] = $permission->misc_id;
        }
    }

    /**
     * Load the user's permissions. This table doesn't involve the campaign_id of the campaign, so we
     * have to load every permission...
     * Todo: add a limit to the current campaign
     */
    protected function loadUserPermissions(): void
    {
        if ($this->admin) {
            return;
        }

        // If we have a user, they might have individual entity permissions
        $permissions = CampaignPermission::where('user_id', $this->user->id)
            ->where('campaign_id', $this->campaign->id)
            ->get();
        foreach ($permissions as $permission) {
            $this->parseUserPermission($permission);
        }
    }

    /**
     * Parse a permission
     * @param CampaignPermission $permission
     */
    protected function parseUserPermission(CampaignPermission $permission)
    {
        if (!$permission->isAction($this->action)) {
            return;
        }

        // If the permission set is negative, we need to add it to the denied ones too, in case a role of
        // the user has access to this entity.
        if ($permission->access) {
            if (!in_array($permission->entity_id, $this->entityIds)) {
                $this->entityIds[] = $permission->entity_id;
                $this->allowedModels[] = $permission->misc_id;
            }
            // If the user was denied through a role but has access through a direct permissions, still allow them
            if (($key = array_search($permission->entity_id, $this->deniedIds)) !== false) {
                unset($this->deniedIds[$key]);
                if (($key = array_search($permission->misc_id, $this->deniedModels)) !== false) {
                    unset($this->deniedModels[$permission->misc_id]);
                }
            }
            return;
        }

        if (!$permission->access && !in_array($permission->entity_id, $this->deniedIds)) {
            $this->deniedIds[] = $permission->entity_id;
            $this->deniedModels[] = $permission->misc_id;
        }
    }

}
