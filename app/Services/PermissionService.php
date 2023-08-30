<?php

namespace App\Services;

use App\Facades\Module;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Traits\CampaignAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class PermissionService
 * @package App\Services
 */
class PermissionService
{
    use CampaignAware;

    /** @var bool|array Users with a role */
    private $users = false;

    /** @var int */
    private $type;

    /** @var CampaignRole */
    private $role;

    private null|array $idsToCode = null;

    /**
     * Permissions setup on the campaign
     */
    private array $basePermissions;

    protected array $cachedPermissions;

    /**
     * Set the entity type
     * @return $this
     */
    public function type(int $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set the role
     * @return $this
     */
    public function role(CampaignRole $role): self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Get the campaign role permissions. First key is the entity type
     */
    public function permissions(CampaignRole $role): array
    {
        $permissions = [];

        $campaignRolePermissions = [];
        foreach ($role->rolePermissions as $perm) {
            $campaignRolePermissions[$perm->entity_type_id . '_' . $perm->action] = 1;
        }

        $entityActions = [
            CampaignPermission::ACTION_READ, CampaignPermission::ACTION_EDIT,
            CampaignPermission::ACTION_ADD, CampaignPermission::ACTION_DELETE,
            CampaignPermission::ACTION_POSTS, CampaignPermission::ACTION_PERMS
        ];
        $icons = [
            CampaignPermission::ACTION_READ => [
                'fa-solid fa-eye',
                'read',
            ],
            CampaignPermission::ACTION_EDIT => [
                'fa-solid fa-pen',
                'edit',
            ],
            CampaignPermission::ACTION_ADD => [
                'fa-solid fa-plus-square',
                'add',
            ],
            CampaignPermission::ACTION_DELETE => [
                'fa-solid fa-trash-alt',
                'delete',
            ],
            CampaignPermission::ACTION_POSTS => [
                'fa-solid fa-file',
                'entity-note',
            ],
            CampaignPermission::ACTION_PERMS => [
                'fa-solid fa-cog',
                'permission',
            ],
        ];

        // Public actions
        if ($role->is_public) {
            //$actions = ['read'];
            $entityActions = [CampaignPermission::ACTION_READ];
        }

        foreach ($this->entityTypes() as $name => $id) {
            foreach ($entityActions as $action) {
                if (!isset($permissions[$id])) {
                    $permissions[$id] = [];
                }
                $key = "{$id}_{$action}";
                $permissions[$id][] = [
                    'action' => $action,
                    'key' => $key,
                    'icon' => Arr::first($icons[$action]),
                    'label' => Arr::last($icons[$action]),
                    'enabled' => isset($campaignRolePermissions[$key]),
                ];
            }
        }

        return $permissions;
    }

    /**
     */
    public function entityTypes(): array
    {
        $types = [];
        $excludedEntities = ['bookmark', 'relation'];

        foreach (config('entities.ids') as $name => $id) {
            if (in_array($name, $excludedEntities)) {
                continue;
            }
            $types[$name] = $id;
        }

        return $types;
    }

    /**
     * Determine if the loaded role has the permission to do a specific action on the
     * specified entity type (->type())
     */
    public function can(int $action = CampaignPermission::ACTION_READ): bool
    {
        return $this->role->permissions
            ->where('entity_type_id', $this->type)
            ->where('action', $action)
            ->where('access', true)
            ->count() === 1;
    }

    /**
     * Campaign Permissions
     */
    public function campaignPermissions(CampaignRole $role): array
    {
        $permissions = [];

        $campaignRolePermissions = [];
        foreach ($role->permissions as $perm) {
            if ($perm->entity_type_id) {
                continue;
            }
            $campaignRolePermissions["campaign_" . $perm->action] = 1;
        }

        $entityActions = [
            CampaignPermission::ACTION_MANAGE, CampaignPermission::ACTION_DASHBOARD,
            CampaignPermission::ACTION_MEMBERS, CampaignPermission::ACTION_GALLERY
        ];
        $icons = [
            CampaignPermission::ACTION_MANAGE => [
                'fa-solid fa-cog',
                'manage',
            ],
            CampaignPermission::ACTION_DASHBOARD => [
                'fa-solid fa-columns','dashboard',
            ],
            CampaignPermission::ACTION_MEMBERS => [
                'fa-solid fa-users', 'members',
            ],
            CampaignPermission::ACTION_GALLERY => [
                'fa-solid fa-image', 'gallery',
            ]
        ];

        foreach ($entityActions as $action) {
            if (!isset($permissions['campaign'])) {
                $permissions['campaign'] = [];
            }
            $key = "campaign_{$action}";
            $permissions['campaign'][] = [
                'action' => $action,
                //'table' => $table,
                'key' => $key,
                'icon' => Arr::first($icons[$action]),
                'label' => Arr::last($icons[$action]),
                'enabled' => isset($campaignRolePermissions[$key]),
            ];
        }


        return $permissions;
    }

    /**
     */
    public function saveEntity(array $request, Entity $entity)
    {
        // First, let's get all the stuff for this entity
        $permissions = $this->entityPermissions($entity);

        // Next, start looping the data
        if (!empty($request['role'])) {
            foreach ($request['role'] as $roleId => $data) {
                foreach ($data as $perm => $action) {
                    if ($action === 'allow') {
                        if (empty($permissions['role'][$roleId][$perm])) {
                            CampaignPermission::create([
                                'campaign_role_id' => $roleId,
                                'campaign_id' => $entity->campaign_id,
                                'entity_type_id' => $entity->type_id,
                                'entity_id' => $entity->id,
                                'misc_id' => $entity->child->id,
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
                                'misc_id' => $entity->child->id,
                                'action' => $perm,
                                'access' => false,
                            ]);
                        } else {
                            $permissions['role'][$roleId][$perm]->update(['access' => false]);
                            unset($permissions['role'][$roleId][$perm]);
                        }
                    } else {
                        // Inherit? Remove it if it exists
                        if (!empty($permissions['role'][$roleId][$perm])) {
                            $permissions['role'][$roleId][$perm]->delete();
                        }
                    }
                }
            }
        }
        if (!empty($request['user'])) {
            foreach ($request['user'] as $userId => $data) {
                foreach ($data as $perm => $action) {
                    if ($action === 'allow') {
                        if (empty($permissions['user'][$userId][$perm])) {
                            CampaignPermission::create([
                                'user_id' => $userId,
                                'campaign_id' => $entity->campaign_id,
                                'entity_type_id' => $entity->type_id,
                                'entity_id' => $entity->id,
                                'misc_id' => $entity->child->id,
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
                                'misc_id' => $entity->child->id,
                                'action' => $perm,
                                'access' => false,
                            ]);
                        } else {
                            $permissions['user'][$userId][$perm]->update(['access' => false]);
                            unset($permissions['user'][$userId][$perm]);
                        }
                    } else {
                        // Inherit? Remove it if it exists
                        if (!empty($permissions['user'][$userId][$perm])) {
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
            $entity->is_attributes_private = $privateAttributes;
            $entity->save();
        }
    }

    /**
     * @param array $request
     */
    public function change($request, Entity $entity, bool $override = true)
    {
        // First, let's get all the stuff for this entity
        $permissions = $this->clearEntityPermissions()->entityPermissions($entity);

        // Next, start looping the data
        if (!empty($request['role'])) {
            foreach ($request['role'] as $roleId => $data) {
                foreach ($data as $perm => $action) {
                    if ($action == 'allow') {
                        if (empty($permissions['role'][$roleId][$perm])) {
                            CampaignPermission::create([
                                //'key' => $entity->type() . '_' . $perm . '_' . $entity->child->id,
                                'campaign_role_id' => $roleId,
                                //'campaign_id' => $entity->campaign_id,
                                //'entity_type_id' => $entity->type_id,
                                'entity_id' => $entity->id,
                                'misc_id' => $entity->child->id,
                                'action' => $perm,
                                'access' => true,
                            ]);
                        } else {
                            $permissions['role'][$roleId][$perm]->update(['access' => true]);
                            unset($permissions['role'][$roleId][$perm]);
                        }
                    } elseif ($action == 'remove') {
                        if (!empty($permissions['role'][$roleId][$perm])) {
                            $permissions['role'][$roleId][$perm]->delete();
                            unset($permissions['role'][$roleId][$perm]);
                        }
                    } elseif ($action === 'deny') {
                        if (empty($permissions['role'][$roleId][$perm])) {
                            CampaignPermission::create([
                                //'key' => $entity->type() . '_' . $perm . '_' . $entity->child->id,
                                'campaign_role_id' => $roleId,
                                //'campaign_id' => $entity->campaign_id,
                                //'table_name' => $entity->pluralType(),
                                //'entity_type_id' => $entity->type_id,
                                'entity_id' => $entity->id,
                                'misc_id' => $entity->child->id,
                                'action' => $perm,
                                'access' => false,
                            ]);
                        } else {
                            $permissions['role'][$roleId][$perm]->update(['access' => false]);
                            unset($permissions['role'][$roleId][$perm]);
                        }
                    } elseif ($action == 'inherit') {
                        // Inherit? Remove it if it exists
                        if (!empty($permissions['role'][$roleId][$perm])) {
                            $permissions['role'][$roleId][$perm]->delete();
                        }
                    }
                }
            }
        }
        if (!empty($request['user'])) {
            foreach ($request['user'] as $userId => $data) {
                foreach ($data as $perm => $action) {
                    if ($action == 'allow') {
                        if (empty($permissions['user'][$userId][$perm])) {
                            CampaignPermission::create([
                                //'key' => $entity->type() . '_' . $perm . '_' . $entity->child->id,
                                'user_id' => $userId,
                                'campaign_id' => $entity->campaign_id,
                                'entity_id' => $entity->id,
                                //'entity_type_id' => $entity->type_id,
                                'misc_id' => $entity->child->id,
                                'action' => $perm,
                                'access' => true,
                            ]);
                        } else {
                            $permissions['user'][$userId][$perm]->update(['access' => true]);
                            unset($permissions['user'][$userId][$perm]);
                        }
                    } elseif ($action == 'remove') {
                        if (!empty($permissions['user'][$userId][$perm])) {
                            $permissions['user'][$userId][$perm]->delete();
                            unset($permissions['user'][$userId][$perm]);
                        }
                    } elseif ($action === 'deny') {
                        if (empty($permissions['user'][$userId][$perm])) {
                            CampaignPermission::create([
                                //'key' => $entity->type() . '_' . $perm . '_' . $entity->child->id,
                                'user_id' => $userId,
                                'campaign_id' => $entity->campaign_id,
                                //'table_name' => $entity->pluralType(),
                                'entity_id' => $entity->id,
                                //'entity_type_id' => $entity->type_id,
                                'misc_id' => $entity->child->id,
                                'action' => $perm,
                                'access' => false
                            ]);
                        } else {
                            $permissions['user'][$userId][$perm]->update(['access' => false]);
                        }
                    } elseif ($action == 'inherit') {
                        // Inherit? Remove it if it exists
                        if (!empty($permissions['user'][$userId][$perm])) {
                            $permissions['user'][$userId][$perm]->delete();
                        }
                    }
                }
            }
        }

        // If the user requested an override, any permissions that was not specifically set will be deleted.
        if ($override) {
            foreach ($permissions as $type => $data) {
                foreach ($data as $user => $actions) {
                    foreach ($actions as $action => $perm) {
                        $perm->delete();
                    }
                }
            }
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
            $key = (!empty($perm->user_id) ? 'user' : 'role');
            $subkey = (!empty($perm->user_id) ? $perm->user_id : $perm->campaign_role_id);
            $permissions[$key][$subkey][$perm->action] = $perm;
        }

        return $this->cachedPermissions = $permissions;
    }

    /**
     * @return $this
     */
    protected function clearEntityPermissions(): self
    {
        unset($this->cachedPermissions);
        return $this;
    }

    /**
     */
    public function inherited(int $action, int $role = 0, int $user = 0): bool
    {
        if (empty($this->type)) {
            return false;
        }

        if (!isset($this->basePermissions)) {
            $this->basePermissions = [
                'roles' => [],
                'users' => []
            ];

            /** @var CampaignRole $campaignRole */
            foreach ($this->campaign->roles()->with(['users', 'permissions'])->get() as $campaignRole) {
                $campaignPermissions = $campaignRole->permissions
                    ->whereNull('entity_id')
                    ->whereNull('user_id')
                ;
                $users = $campaignRole->users->pluck('user_id');
                /** @var CampaignPermission $campaignPermission */
                foreach ($campaignPermissions as $campaignPermission) {
                    $key = $campaignPermission->entity_type_id . '_' . $campaignPermission->action;
                    $this->basePermissions['roles'][$campaignRole->id][$key] = true;
                    foreach ($users as $permissionUser) {
                        $this->basePermissions['users'][$permissionUser][$key] = [
                            'role' => $campaignRole->name,
                            'access' => $campaignPermission->access
                        ];
                    }
                }
            }
        }

        $key = $this->type . '_' . $action;
        if (!empty($role)) {
            return Arr::has($this->basePermissions, "roles.{$role}.{$key}");
        }
        return Arr::has($this->basePermissions, "users.{$user}.{$key}");
    }

    /**
     */
    public function inheritedRoleName(int $action, int $user): string
    {
        $key = $this->type . '_' . $action;
        return $this->basePermissions['users'][$user][$key]['role'];
    }

    /**
     */
    public function inheritedRoleAccess(int $action, int $user): bool
    {
        $key = $this->type . '_' . $action;
        return $this->basePermissions['users'][$user][$key]['access'];
    }

    /**
     */
    public function selected(string $type, int $user, int $action): string
    {
        if (!isset($this->cachedPermissions)) {
            return 'inherit';
        }
        $value = Arr::get($this->cachedPermissions, $type . '.' . $user . '.' . $action, null);
        if ($value === null) {
            return 'inherit';
        }
        return $value->access ? 'allow' : 'deny';
    }

    /**
     * @return array
     */
    public function users()
    {
        if ($this->users === false) {
            $this->users = $this->campaign
                ->members()
                ->withoutAdmins()
                ->with(['user', 'user.campaignRoles'])
                ->get();
        }
        return $this->users;
    }

    /**
     */
    public function entityType(int $entityType): string
    {
        $flip = array_flip(config('entities.ids'));
        $plural = Module::plural($flip[$entityType]);
        if (!empty($plural)) {
            return $plural;
        }
        return 'entities.' . Str::plural($flip[$entityType]);
    }

    public function entityTypePlural(int $entityType): string
    {
        return Str::plural($this->code($entityType));
    }

    protected function code(int $entityType): string
    {
        if ($this->idsToCode === null) {
            $this->idsToCode = array_flip(config('entities.ids'));
        }
        return $this->idsToCode[$entityType];
    }
    public function duplicate(int $roleId)
    {
        $oldRole = CampaignRole::where('id', $roleId)->first();
        foreach ($oldRole->permissions as $permission) {
            /** @var CampaignPermission $newPermission */
            $newPermission = $permission->replicate(['campaign_role_id']);
            $newPermission->campaign_role_id = $this->role->id;
            $newPermission->save();
        }
    }
}
