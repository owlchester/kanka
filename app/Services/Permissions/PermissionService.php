<?php

namespace App\Services\Permissions;

use App\Enums\Permission;
use App\Facades\UserCache;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Models\PostPermission;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionService
{
    use CampaignAware;
    use UserAware;

    /** @var int CampaignPermission::ACTION_READ etc */
    protected int $action;

    /** @var array Entity IDs and Types the user can access */
    protected array $entityIds = [];

    protected array $entityTypes = [];

    protected array $entityTypesIds = [];

    protected array $deniedIds = [];

    protected array $allowedModels = [];

    protected array $deniedModels = [];

    protected bool $loadedPermissions = false;

    protected bool $tempPermissionCreated = false;

    protected bool $tempPermissionFilled = false;

    /** @var array Permissions for posts */
    protected array $allowedPostIDs = [];

    protected array $deniedPostIDs = [];

    protected bool $loadedPosts = false;

    protected int $loadedRoles;

    protected bool $admin = false;

    protected bool $granted = false;

    /** @var int the entity type if provided to limit queries */
    protected int $entityType;

    protected int $entityTypeID;

    protected float $start;

    public function isAdmin(): bool
    {
        $this->loadPermissions();

        return $this->admin;
    }

    public function entityTypeID(int $id): self
    {
        $this->entityTypeID = $id;

        return $this;
    }

    /**
     * Set the desired action
     */
    public function action(Permission $permission): self
    {
        $this->action = $permission->value;

        return $this;
    }

    public function reload(): self
    {
        $this->entityIds = [];
        $this->entityTypes = [];
        $this->entityTypesIds = [];
        $this->deniedIds = [];
        unset($this->loadedRoles);
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
     */
    public function allowedPosts(): array
    {
        return $this->loadPostPermissions()
            ->allowedPostIDs();
    }

    /**
     * List of post ids the user doesn't have access to
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

    public function createTemporaryTable(): self
    {
        if ($this->tempPermissionFilled) {
            return $this;
        }
        if (! $this->tempPermissionCreated) {
            Schema::create('tmp_permissions', function (Blueprint $table) {
                $table->unsignedInteger('id');
                $table->temporary();
            });
            $this->tempPermissionCreated = true;
            $this->tune('Temp table created');
        }
        $batch = [];
        foreach ($this->entityIds as $id) {
            $batch[] = $id;
            if (count($batch) > 900) {
                DB::statement('INSERT INTO tmp_permissions (id) VALUES (' . implode(') ,(', $batch) . ')');
                $batch = [];
            }
        }
        if (count($batch) > 0) {
            DB::statement('INSERT INTO tmp_permissions (id) VALUES (' . implode(') ,(', $batch) . ')');
        }
        //        dump(in_array(329259, $batch));
        //        $wa = DB::table('tmp_permissions')
        //            ->where('id', 329259)->get();
        //        dd($wa);
        $this->tempPermissionFilled = true;
        $this->tune('Temp table filled');

        return $this;
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
     */
    public function grant(Entity $entity): self
    {
        $this->granted = true;
        $this->entityIds[] = $entity->id;
        $this->allowedModels[] = $entity->entity_id;
        $this->tempPermissionFilled = false;

        return $this;
    }

    /**
     * Was a permission granted?
     */
    public function granted(): bool
    {
        return $this->granted;
    }

    /**
     * Load the permissions for posts
     */
    protected function loadPostPermissions(): self
    {
        if ($this->loadedPosts) {
            return $this;
        }
        $this->loadedPosts = true;

        // Get the user's individual and role permissions
        $roles = $this->userRoles();
        $perms = PostPermission::select(['post_id', 'permission'])
            ->leftJoin('posts as p', 'p.id', 'post_permissions.post_id')
            ->leftJoin('entities as e', 'e.id', 'p.entity_id')
            ->where(function ($sub) use ($roles) {
                $sub->where('user_id', $this->user->id)
                    ->orWhereIn('role_id', $roles);
            })
            ->where('e.campaign_id', $this->campaign->id)
            ->get();
        /** @var PostPermission $perm */
        foreach ($perms as $perm) {
            if ($perm->permission === 2) {
                $this->deniedPostIDs[] = $perm->post_id;
            } else {
                $this->allowedPostIDs[] = $perm->post_id;
            }
        }

        return $this;
    }

    /**
     * Load the permissions of the user (roles and personal permissions)
     */
    private function loadPermissions(): self
    {
        if ($this->loadedPermissions) {
            return $this;
        }

        $this->start = microtime(true);
        $this->loadedPermissions = true;

        // Valid user: load their roles
        if ($this->hasUser()) {
            $this->loadRoles();
            $this->loadUserPermissions();
            $this->tune('Perms loaded for user');
        }

        // If the user had no loaded roles, we need a public role
        if (isset($this->loadedRoles) && $this->loadedRoles > 0) {
            return $this;
        }
        $this->loadPublicRole();
        $this->tune('Perms loaded with public');

        return $this;
    }

    public function reset(): self
    {
        $this->loadedPermissions = false;
        unset($this->loadedRoles);
        $this->admin = false;

        return $this;
    }

    /**
     * Load the user's roles
     */
    protected function loadRoles(): self
    {
        if (isset($this->loadedRoles)) {
            return $this;
        }
        $this->loadedRoles = 0;

        $roles = UserCache::user($this->user)->roles();

        $roleIDs = [];
        foreach ($roles as $role) {
            $this->loadedRoles++;
            // If one of the roles is an admin, we don't need to figure any more stuff, we're good.
            if ($role['is_admin']) {
                $this->admin = true;

                return $this;
            }
            $roleIDs[] = $role['id'];
        }
        $this->parseRoles($roleIDs);

        return $this;
    }

    /**
     * Load public role permissions as a fall-back for non-members of the campaign.
     */
    protected function loadPublicRole(): void
    {
        /** @var CampaignRole $publicRole */
        $publicRole = $this->campaign
            ->roles()
            ->where('is_public', true)
            ->first();
        if ($publicRole) {
            $this->parseRole($publicRole);
        }
    }

    /**
     * Load the permissions of a role into the service
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
     */
    protected function parseRoles(array $roleIDs): void
    {
        // Loop through the permissions of the role to get any blanket _read permissions on entities
        $permissions = \App\Facades\RolePermission::rolesPermissions($roleIDs);
        // dump($permissions);
        // CampaignPermission::whereIn('campaign_role_id', $roleIDs)->get();
        foreach ($permissions as $permission) {
            $this->parseRolePermission($permission);
        }
    }

    /**
     * Parse a role permission
     */
    protected function parseRolePermission(CampaignPermission $permission)
    {
        // Only test permissions whose action is being requested
        if (isset($this->action) && ! $permission->isAction($this->action)) {
            return;
        }
        if (isset($this->entityType) && ! empty($this->entityType) && $permission->entity_type_id !== $this->entityType) {
            return;
        }
        if (isset($this->entityTypeID) && ! empty($permission->entity_type_id) && $permission->entity_type_id !== $this->entityTypeID) {
            return;
        }

        if (empty($permission->entity_id)) {
            if (! in_array($permission->entity_type_id, $this->entityTypesIds)) {
                $this->entityTypesIds[] = $permission->entity_type_id;
            }
        } elseif ($permission->access && ! in_array($permission->entity_id, $this->entityIds)) {
            // This permission targets an entity directly
            $this->entityIds[] = $permission->entity_id;

            if (! empty($permission->misc_id)) {
                $this->allowedModels[] = $permission->misc_id;
            }
        } elseif (! $permission->access && ! in_array($permission->entity_id, $this->deniedIds)) {
            // This permission targets an entity directly
            $this->deniedIds[] = $permission->entity_id;
            if (! empty($permission->misc_id)) {
                $this->deniedModels[] = $permission->misc_id;
            }
        }
    }

    /**
     * Load the user's permissions.
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
     */
    protected function parseUserPermission(CampaignPermission $permission)
    {
        if (isset($this->action) && ! $permission->isAction($this->action)) {
            return;
        }

        // If the permission set is negative, we need to add it to the denied ones too, in case a role of
        // the user has access to this entity.
        if ($permission->access) {
            if (! in_array($permission->entity_id, $this->entityIds)) {
                $this->entityIds[] = $permission->entity_id;
                if (! empty($permission->misc_id)) {
                    $this->allowedModels[] = $permission->misc_id;
                }
            }
            // If the user was denied through a role but has access through a direct permissions, still allow them
            if (($key = array_search($permission->entity_id, $this->deniedIds)) !== false) {
                unset($this->deniedIds[$key]);
                if (! empty($permission->misc_id)) {
                    if (($key = array_search($permission->misc_id, $this->deniedModels)) !== false) {
                        unset($this->deniedModels[$key]);
                    }
                }
            }

            return;
        }

        if (! in_array($permission->entity_id, $this->deniedIds)) {
            $this->deniedIds[] = $permission->entity_id;
            if (! empty($permission->misc_id)) {
                $this->deniedModels[] = $permission->misc_id;
            }
        }
    }

    protected function tune(string $log): void
    {
        return;
//        if (!isset($this->campaign)) {
//            return;
//        }
//        if ($this->campaign->id !== 1) {
//            return;
//        }
//
//        Log::info($log . ' in ' . round(microtime(true) - $this->start, 3) . 's');
    }

    protected function userRoles(): array
    {
        return UserCache::user($this->user)
            ->roles()
            ->pluck('id')
            ->toArray();
    }
}
