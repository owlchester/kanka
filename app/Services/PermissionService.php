<?php

namespace App\Services;

use App\Enums\Permission;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\RoleAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;

/**
 * Class PermissionService
 */
class PermissionService
{
    use CampaignAware;
    use RoleAware;
    use UserAware;

    /** @var int */
    private $type;

    protected int $action;

    /**
     * Permissions setup on the campaign
     */
    private array $basePermissions;

    protected array $cachedPermissions;

    /**
     * Set the entity type
     */
    public function type(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function action(Permission $action): self
    {
        $this->action = $action->value;

        return $this;
    }

    public function saveEntity(array $request, Entity $entity): void
    {
        // First, let's get all the stuff for this entity
        $permissions = $this->entityPermissions($entity);

        // Next, start looping the data
        if (! empty($request['role'])) {
            foreach ($request['role'] as $roleId => $data) {
                foreach ($data as $perm => $action) {
                    if ($action === 'allow') {
                        if (empty($permissions['role'][$roleId][$perm])) {
                            CampaignPermission::create([
                                'campaign_role_id' => $roleId,
                                'campaign_id' => $entity->campaign_id,
                                'entity_type_id' => $entity->type_id,
                                'entity_id' => $entity->id,
                                'misc_id' => $entity->entityType->isSpecial() ? null : $entity->child->id,
                                'action' => $perm,
                                'access' => true,
                            ]);
                        } else {
                            $permissions['role'][$roleId][$perm]->update(['access' => true]);
                            unset($permissions['role'][$roleId][$perm]);
                        }
                    } elseif ($action === 'deny') {
                        if (empty($permissions['role'][$roleId][$perm])) {
                            CampaignPermission::create([
                                'campaign_role_id' => $roleId,
                                'campaign_id' => $entity->campaign_id,
                                'entity_type_id' => $entity->type_id,
                                'entity_id' => $entity->id,
                                'misc_id' => $entity->entityType->isSpecial() ? null : $entity->child->id,
                                'action' => $perm,
                                'access' => false,
                            ]);
                        } else {
                            $permissions['role'][$roleId][$perm]->update(['access' => false]);
                            unset($permissions['role'][$roleId][$perm]);
                        }
                    } else {
                        // Inherit? Remove it if it exists
                        if (! empty($permissions['role'][$roleId][$perm])) {
                            $permissions['role'][$roleId][$perm]->delete();
                        }
                    }
                }
            }
        }
        if (! empty($request['user'])) {
            foreach ($request['user'] as $userId => $data) {
                foreach ($data as $perm => $action) {
                    if ($action === 'allow') {
                        if (empty($permissions['user'][$userId][$perm])) {
                            CampaignPermission::create([
                                'user_id' => $userId,
                                'campaign_id' => $entity->campaign_id,
                                'entity_type_id' => $entity->type_id,
                                'entity_id' => $entity->id,
                                'misc_id' => $entity->entityType->isSpecial() ? null : $entity->child->id,
                                'action' => $perm,
                                'access' => true,
                            ]);
                        } else {
                            $permissions['user'][$userId][$perm]->update(['access' => true]);
                            unset($permissions['user'][$userId][$perm]);
                        }
                    } elseif ($action === 'deny') {
                        if (empty($permissions['user'][$userId][$perm])) {
                            CampaignPermission::create([
                                'user_id' => $userId,
                                'campaign_id' => $entity->campaign_id,
                                'entity_type_id' => $entity->type_id,
                                'entity_id' => $entity->id,
                                'misc_id' => $entity->entityType->isSpecial() ? null : $entity->child->id,
                                'action' => $perm,
                                'access' => false,
                            ]);
                        } else {
                            $permissions['user'][$userId][$perm]->update(['access' => false]);
                            unset($permissions['user'][$userId][$perm]);
                        }
                    } else {
                        // Inherit? Remove it if it exists
                        if (! empty($permissions['user'][$userId][$perm])) {
                            $permissions['user'][$userId][$perm]->delete();
                        }
                    }
                }
            }
        }

        // Delete remaining permissions
        $skipUsers = Arr::has($request, 'permissions_too_many');
        foreach ($permissions as $type => $data) {
            // Skip users if there are too many users in the UI
            if ($type === 'user' && $skipUsers) {
                continue;
            }
            foreach ($data as $user => $actions) {
                foreach ($actions as $action => $perm) {
                    $perm->delete();
                }
            }
        }

        // Campaign admins can hide all attributes from an entity
        if (auth()->user()->isAdmin()) {
            $privateAttributes = Arr::get($request, 'is_attributes_private', false);
            $entity->is_attributes_private = $privateAttributes ? 1 : 0;
        }
    }

    /**
     * Get the permissions of an entity
     */
    public function entityPermissions(Entity $entity): array
    {
        if (isset($this->cachedPermissions)) {
            return $this->cachedPermissions;
        }

        $permissions = ['user' => [], 'role' => []];
        /** @var CampaignPermission $perm */
        foreach (CampaignPermission::where('entity_id', $entity->id)->get() as $perm) {
            $key = (! empty($perm->user_id) ? 'user' : 'role');
            $subkey = (! empty($perm->user_id) ? $perm->user_id : $perm->campaign_role_id);
            $permissions[$key][$subkey][$perm->action] = $perm;
        }

        return $this->cachedPermissions = $permissions;
    }

    public function clearEntityPermissions(): self
    {
        unset($this->cachedPermissions);

        return $this;
    }

    public function inherited(): bool
    {
        if (empty($this->type)) {
            return false;
        }

        if (! isset($this->basePermissions)) {
            $this->basePermissions = [
                'roles' => [],
                'users' => [],
            ];

            /** @var CampaignRole $campaignRole */
            foreach ($this->campaign->roles()->with(['users', 'permissions'])->get() as $campaignRole) {
                $campaignPermissions = $campaignRole->permissions
                    ->whereNull('entity_id')
                    ->whereNull('user_id');
                $users = $campaignRole->users->pluck('user_id');
                /** @var CampaignPermission $campaignPermission */
                foreach ($campaignPermissions as $campaignPermission) {
                    $key = $campaignPermission->entity_type_id . '_' . $campaignPermission->action;
                    $this->basePermissions['roles'][$campaignRole->id][$key] = true;
                    foreach ($users as $permissionUser) {
                        $this->basePermissions['users'][$permissionUser][$key] = [
                            'role' => $campaignRole->name,
                            'access' => $campaignPermission->access,
                        ];
                    }
                }
            }
        }

        $key = $this->type . '_' . $this->action;
        if (isset($this->role)) {
            return Arr::has($this->basePermissions, "roles.{$this->role->id}.{$key}");
        }

        return Arr::has($this->basePermissions, "users.{$this->user->id}.{$key}");
    }

    public function inheritedRoleName(): string
    {
        $key = $this->type . '_' . $this->action;

        return $this->basePermissions['users'][$this->user->id][$key]['role'];
    }

    public function inheritedRoleAccess(): bool
    {
        $key = $this->type . '_' . $this->action;

        return $this->basePermissions['users'][$this->user->id][$key]['access'];
    }

    public function selected(string $type): string
    {
        if (! isset($this->cachedPermissions)) {
            return 'inherit';
        }
        $user = isset($this->user) ? $this->user->id : $this->role->id;
        $value = Arr::get($this->cachedPermissions, $type . '.' . $user . '.' . $this->action, null);
        if ($value === null) {
            return 'inherit';
        }

        return $value->access ? 'allow' : 'deny';
    }

    public function reset(): self
    {
        unset($this->user, $this->role, $this->action);

        return $this;
    }
}
