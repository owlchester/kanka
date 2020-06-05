<?php

namespace App\Services;

use App\Models\CampaignUser;
use App\Exceptions\RequireLoginException;
use App\Models\CampaignInvite;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Models\MiscModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class PermissionService
 * @package App\Services
 */
class PermissionService
{
    /**
     * @var EntityService
     */
    private $entityService;

    /**
     * @var MiscModel
     */
    private $baseModel;

    /**
     * @var string
     */
    private $type;

    /**
     * Permissions setup on the campaign
     * @var bool|array
     */
    private $basePermissions = false;
    /**
     * @var array
     */
    public $entityActions = [
        'read',
        'edit',
        'delete',
        'entity-note'
    ];

    /** @var bool  */
    protected $cachedPermissions = false;

    /**
     * PermissionService constructor.
     * @param EntityService $entityService
     */
    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    /**
     * @param MiscModel $model
     * @return $this
     */
    public function base(MiscModel $model): self
    {
        $this->baseModel = $model;
        return $this;
    }

    /**
     * Set the entity type
     * @param string $type
     * @return PermissionService
     */
    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the campaign role permissions. First key is the entity type
     * @param CampaignRole $role
     * @return array
     */
    public function permissions(CampaignRole $role): array
    {
        $permissions = [];

        $campaignRolePermissions = [];
        foreach ($role->permissions as $perm) {
            $campaignRolePermissions[$perm->key] = 1;
        }

        $entityActions = ['read', 'edit', 'add', 'delete', 'entity-note', 'permission'];
        $icons = [
            'read' => [
                'fa fa-eye',
                'fa fa-eye-slash',
            ],
            'edit' => [
                'fa fa-pen',
                'fa fa-pen',
            ],
            'add' => [
                'fas fa-plus-square',
                'far fa-plus-square',
            ],
            'delete' => [
                'fas fa-trash-alt',
                'far fa-trash-alt',
            ],
            'entity-note' => [
                'fas fa-file',
                'far fa-file',
            ],
            'permission' => [
                'fa fa-cog',
                'fa fa-cog',
            ],
        ];
        //$actions = ['read', 'edit', 'add', 'delete'];

        // Public actions
        if ($role->is_public) {
            //$actions = ['read'];
            $entityActions = ['read'];
        }

        $excludedEntities = ['menu_links'];

        foreach ($this->entityService->entities() as $entity => $class) {
            if (in_array($entity, $excludedEntities)) {
                continue;
            }
            $singularEntity = $this->entityService->singular($entity);

            foreach ($entityActions as $action) {
                if (!isset($permissions[$entity])) {
                    $permissions[$entity] = [];
                }
                $key = "{$singularEntity}_{$action}";
                $table = $key;
                $permissions[$entity][] = [
                    'action' => $action,
                    'table' => $table,
                    'key' => $key,
                    'icons' => $icons[$action],
                    'enabled' => isset($campaignRolePermissions[$key]),
                ];
            }
        }

        return $permissions;
    }

    /**
     * @param $request
     * @param Entity $entity
     */
    public function saveEntity($request, Entity $entity)
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
                                'key' => $entity->type . '_' . $perm . '_' . $entity->child->id,
                                'campaign_role_id' => $roleId,
                                'table_name' => $entity->pluralType(),
                                'entity_id' => $entity->id,
                                'access' => true
                            ]);
                        } else {
                            $permissions['role'][$roleId][$perm]->update(['access' => true]);
                            unset($permissions['role'][$roleId][$perm]);
                        }
                    } elseif ($action === 'deny') {
                        if (empty($permissions['role'][$roleId][$perm])) {
                            CampaignPermission::create([
                                'key' => $entity->type . '_' . $perm . '_' . $entity->child->id,
                                'campaign_role_id' => $roleId,
                                'table_name' => $entity->pluralType(),
                                'entity_id' => $entity->id,
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
                                'key' => $entity->type . '_' . $perm . '_' . $entity->child->id,
                                'user_id' => $userId,
                                'table_name' => $entity->pluralType(),
                                'entity_id' => $entity->id,
                                'access' => true,
                            ]);
                        } else {
                            $permissions['user'][$userId][$perm]->update(['access' => true]);
                            unset($permissions['user'][$userId][$perm]);
                        }
                    } elseif ($action === 'deny') {

                        if (empty($permissions['user'][$userId][$perm])) {
                            CampaignPermission::create([
                                'key' => $entity->type . '_' . $perm . '_' . $entity->child->id,
                                'user_id' => $userId,
                                'table_name' => $entity->pluralType(),
                                'entity_id' => $entity->id,
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
        if (Auth::user()->isAdmin()) {
            $privateAttributes = Arr::get($request, 'is_attributes_private', false);
            $entity->is_attributes_private = $privateAttributes;
            $entity->save();
        }
    }

    /**
     * @param $request
     * @param Entity $entity
     * @param bool $override
     */
    public function change($request, Entity $entity, bool $override = true)
    {
        // First, let's get all the stuff for this entity
        $permissions = $this->entityPermissions($entity);

        // Next, start looping the data
        if (!empty($request['role'])) {
            foreach ($request['role'] as $roleId => $data) {
                foreach ($data as $perm => $action) {
                    if ($action == 'allow') {
                        if (empty($permissions['role'][$roleId][$perm])) {
                            CampaignPermission::create([
                                'key' => $entity->type . '_' . $perm . '_' . $entity->child->id,
                                'campaign_role_id' => $roleId,
                                'table_name' => $entity->pluralType(),
                                'entity_id' => $entity->id,
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
                                'key' => $entity->type . '_' . $perm . '_' . $entity->child->id,
                                'campaign_role_id' => $roleId,
                                'table_name' => $entity->pluralType(),
                                'entity_id' => $entity->id,
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
                                'key' => $entity->type . '_' . $perm . '_' . $entity->child->id,
                                'user_id' => $userId,
                                'table_name' => $entity->pluralType(),
                                'entity_id' => $entity->id,
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
                                'key' => $entity->type . '_' . $perm . '_' . $entity->child->id,
                                'user_id' => $userId,
                                'table_name' => $entity->pluralType(),
                                'entity_id' => $entity->id,
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
     * @param Entity $entity
     * @return mixed
     */
    public function entityPermissions(Entity $entity): array
    {
        if (!empty($this->cachedPermissions)) {
            return $this->cachedPermissions;
        }

        $keyBase = $entity->type . '_';
        $keys = [];

        foreach ($this->entityActions as $action) {
            $keys[] = $keyBase . $action . '_' . $entity->child->id;
        }

        $permissions = ['user' => [], 'role' => []];
        /** @var CampaignPermission $perm */
        foreach (CampaignPermission::whereIn('key', $keys)->get() as $perm) {
            $key = (!empty($perm->user_id) ? 'user' : 'role');
            $subkey = (!empty($perm->user_id) ? $perm->user_id : $perm->campaign_role_id);
            $permissions[$key][$subkey][$perm->action()] = $perm;
        }


        return $this->cachedPermissions = $permissions;
    }

    /**
     * @param string $action
     * @param int $role
     * @param int $user
     * @return bool
     */
    public function inherited(string $action, int $role = 0, int $user = 0): bool
    {
        if (empty($this->type)) {
            return false;
        }

        if ($this->basePermissions === false) {
            $campaign = \App\Facades\CampaignLocalization::getCampaign();
            $this->basePermissions = [
                'roles' => [],
                'users' => []
            ];

            /** @var CampaignRole $role */
            foreach ($campaign->roles()->with('users')->get() as $campaignRole) {
                $campaignPermissions = $campaignRole->permissions()
                    ->whereNull('entity_id')
                    ->whereNull('user_id')
                    ->get();
                $users = $campaignRole->users->pluck('user_id');
                /** @var CampaignPermission $campaignPermission */
                foreach ($campaignPermissions as $campaignPermission) {
                    $key = $campaignPermission->key;
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
            return Arr::has($this->basePermissions, "roles.$role.$key");
        }
        return Arr::has($this->basePermissions, "users.$user.$key");
    }

    /**
     * @param string $action
     * @param int $user
     * @return string
     */
    public function inheritedRoleName(string $action, int $user): string
    {
        $key = $this->type . '_' . $action;
        return $this->basePermissions['users'][$user][$key]['role'];
    }

    /**
     * @param string $action
     * @param int $user
     * @return string
     */
    public function inheritedRoleAccess(string $action, int $user): bool
    {
        $key = $this->type . '_' . $action;
        return $this->basePermissions['users'][$user][$key]['access'];
    }

    /**
     * @param string $type
     * @param int $user
     * @param string $action
     * @return string
     */
    public function selected(string $type, int $user, string $action): string
    {
        $value = Arr::get($this->cachedPermissions, $type . '.' . $user . '.' . $action, null);
        if ($value === null) {
            return 'inherit';
        }
        return $value->access ? 'allow' : 'deny';
    }
}
