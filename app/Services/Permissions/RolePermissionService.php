<?php

namespace App\Services\Permissions;

use App\Enums\Permission;
use App\Models\CampaignPermission;
use App\Models\EntityType;
use App\Traits\CampaignAware;
use App\Traits\RoleAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RolePermissionService
{
    use CampaignAware;
    use RoleAware;

    protected int $type;

    public function type(int $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the campaign role permissions. First key is the entity type
     */
    public function permissions(): array
    {
        $permissions = [];

        $campaignRolePermissions = [];
        foreach ($this->role->rolePermissions as $perm) {
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
        if ($this->role->isPublic()) {
            //$actions = ['read'];
            $entityActions = [CampaignPermission::ACTION_READ];
        }

        foreach (EntityType::exclude([config('entities.ids.bookmark')])->inCampaign($this->campaign)->get() as $entityType) {
            foreach ($entityActions as $action) {
                if (!isset($permissions[$entityType->plural()])) {
                    $permissions[$entityType->plural()] = [
                        'entityType' => $entityType,
                        'permissions' => []
                    ];
                }
                $key = "{$entityType->id}_{$action}";
                $permissions[$entityType->plural()]['permissions'][] = [
                    'action' => $action,
                    'key' => $key,
                    'icon' => Arr::first($icons[$action]),
                    'label' => Arr::last($icons[$action]),
                    'enabled' => isset($campaignRolePermissions[$key]),
                ];
            }
        }

        $collator = new \Collator(app()->getLocale());
        $collator->asort($permissions);

        $keys = array_keys($permissions);
        $collator->sort($keys);
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $permissions[$key];
        }

        return $result;
    }
    /**
     * Campaign Permissions
     */
    public function campaignPermissions(): array
    {
        $permissions = [];

        $campaignRolePermissions = [];
        foreach ($this->role->permissions as $perm) {
            if ($perm->entity_type_id || $perm->isGallery()) {
                continue;
            }
            $campaignRolePermissions["campaign_" . $perm->action] = 1;
        }

        $entityActions = [
            CampaignPermission::ACTION_MANAGE, CampaignPermission::ACTION_DASHBOARD,
            CampaignPermission::ACTION_MEMBERS
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
        ];

        foreach ($entityActions as $action) {
            if (!isset($permissions['campaign'])) {
                $permissions['campaign'] = [];
            }
            $key = "campaign_{$action}";
            $permissions['campaign'][] = [
                'action' => $action,
                'key' => $key,
                'icon' => Arr::first($icons[$action]),
                'label' => Arr::last($icons[$action]),
                'enabled' => isset($campaignRolePermissions[$key]),
            ];
        }
        return $permissions;
    }

    public function galleryPermissions(): array
    {
        $permissions = [];

        $campaignRolePermissions = [];
        foreach ($this->role->permissions as $perm) {
            if ($perm->entity_type_id || !$perm->isGallery()) {
                continue;
            }
            $campaignRolePermissions["campaign_" . $perm->action] = 1;
        }

        $entityActions = [
            CampaignPermission::ACTION_GALLERY,
            CampaignPermission::ACTION_GALLERY_BROWSE,
            CampaignPermission::ACTION_GALLERY_UPLOAD
        ];
        $icons = [
            CampaignPermission::ACTION_GALLERY => [
                'fa-solid fa-cog', 'gallery.manage',
            ],
            CampaignPermission::ACTION_GALLERY_BROWSE => [
                'fa-solid fa-eye','gallery.browse',
            ],
            CampaignPermission::ACTION_GALLERY_UPLOAD => [
                'fa-solid fa-upload', 'gallery.upload',
            ],
        ];

        foreach ($entityActions as $action) {
            if (!isset($permissions['campaign'])) {
                $permissions['campaign'] = [];
            }
            $key = "campaign_{$action}";
            $permissions['campaign'][] = [
                'action' => $action,
                'key' => $key,
                'icon' => Arr::first($icons[$action]),
                'label' => Arr::last($icons[$action]),
                'enabled' => isset($campaignRolePermissions[$key]),
            ];
        }
        return $permissions;
    }

    public function templatePermissions(): array
    {
        $permissions = [];

        $campaignRolePermissions = [];
        foreach ($this->role->permissions as $perm) {
            if ($perm->entity_type_id || !$perm->isTemplate()) {
                continue;
            }
            $campaignRolePermissions["campaign_" . $perm->action] = 1;
        }

        $entityActions = [
            CampaignPermission::ACTION_TEMPLATES,
            CampaignPermission::ACTION_POST_TEMPLATES,

        ];
        $icons = [
            CampaignPermission::ACTION_TEMPLATES => [
                'fa-solid fa-cog', 'entities',
            ],
            CampaignPermission::ACTION_POST_TEMPLATES => [
                'fa-solid fa-cog', 'posts',
            ],
        ];

        foreach ($entityActions as $action) {
            if (!isset($permissions['campaign'])) {
                $permissions['campaign'] = [];
            }
            $key = "campaign_{$action}";
            $permissions['campaign'][] = [
                'action' => $action,
                'key' => $key,
                'icon' => Arr::first($icons[$action]),
                'label' => Arr::last($icons[$action]),
                'enabled' => isset($campaignRolePermissions[$key]),
            ];
        }
        return $permissions;
    }

    public function bookmarkPermissions(): array
    {
        $permissions = [];

        $campaignRolePermissions = [];
        foreach ($this->role->permissions as $perm) {
            if ($perm->entity_type_id || !$perm->isBookmark()) {
                continue;
            }
            $campaignRolePermissions["campaign_" . $perm->action] = 1;
        }

        $entityActions = [
            CampaignPermission::ACTION_BOOKMARKS,
        ];
        $icons = [
            CampaignPermission::ACTION_BOOKMARKS => [
                'fa-solid fa-cog', 'manage',
            ],
        ];

        foreach ($entityActions as $action) {
            if (!isset($permissions['campaign'])) {
                $permissions['campaign'] = [];
            }
            $key = "campaign_{$action}";
            $permissions['campaign'][] = [
                'action' => $action,
                'key' => $key,
                'icon' => Arr::first($icons[$action]),
                'label' => Arr::last($icons[$action]),
                'enabled' => isset($campaignRolePermissions[$key]),
            ];
        }
        return $permissions;
    }

    public function savePermissions(array $permissions = []): void
    {
        // Load existing
        $existing = [];
        foreach ($this->role->rolePermissions as $permission) {
            if (empty($permission->entity_type_id)) {
                $existing['campaign_' . $permission->action] = $permission;
                continue;
            }
            $existing[$permission->entity_type_id . '_' . $permission->action] = $permission;
        }

        // Loop on submitted form
        if (empty($permissions)) {
            $permissions = [];
        }

        foreach ($permissions as $key => $module) {
            // Check if exists$
            if (isset($existing[$key])) {
                // Do nothing
                unset($existing[$key]);
            } else {
                $action = Str::after($key, '_');
                if ($module === 'campaign') {
                    $module = 0;
                }

                $this->add($module, (int) $action);
            }
        }

        // Delete existing that weren't updated
        foreach ($existing as $permission) {
            // Only delete if it's a "general" and not an entity specific permission
            if (!is_numeric($permission->entity_id)) {
                $permission->delete();
            }
        }
    }

    /**
     * Toggle an entity's action permission
     */
    public function toggle(int $entityType, int $action): bool
    {
        $perm = $this->role->permissions()
            ->where('entity_type_id', $entityType)
            ->where('action', $action)
            ->whereNull('entity_id')
            ->first();

        if ($perm) {
            $perm->delete();
            return false;
        }

        $this->add($entityType, $action);
        return true;
    }

    /**
     * Determine if the loaded role has the permission to do a specific action on the
     * specified entity type (->type())
     */
    public function can(Permission $permission): bool
    //int $action = CampaignPermission::ACTION_READ): bool
    {
        return $this->role->permissions
            ->where('entity_type_id', $this->type)
            ->whereNull('entity_id')
            ->where('action', $permission->value)
            ->where('access', true)
            ->count() === 1;
    }

    /**
     * Add a campaign permission for the role
     */
    protected function add(int $entityType, int $action): CampaignPermission
    {
        if ($entityType === 0) {
            $entityType = null;
        }
        return CampaignPermission::create([
            //'key' => $key,
            'campaign_role_id' => $this->role->id,
            //'table_name' => $value,
            'access' => true,
            'action' => $action,
            'entity_type_id' => $entityType
            //'campaign_id' => $campaign->id,
        ]);
    }
}
