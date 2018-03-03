<?php

namespace App\Services;

use App\CampaignUser;
use App\Exceptions\RequireLoginException;
use App\Models\CampaignInvite;
use App\Models\CampaignRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PermissionService
{
    /**
     * @var EntityService
     */
    private $entityService;

    /**
     * PermissionService constructor.
     * @param EntityService $entityService
     */
    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    public function permissions(CampaignRole $role)
    {
        $permissions = [];

        $campaignRolePermissions = [];
        foreach ($role->permissions as $perm) {
            $campaignRolePermissions[$perm->key] = 1;
        }

        $actions = ['browse', 'read', 'edit', 'add', 'delete', 'move', 'permission'];

        foreach ($this->entityService->entities() as $entity => $class) {
            $singularEntity = $this->entityService->singular($entity);

            foreach ($actions as $action) {
                $key = "{$singularEntity}_{$action}";
                $table = $key;
                $permissions[] = [
                    'entity' => $entity,
                    'action' => $action,
                    'table' => $table,
                    'key' => $key,
                    'enabled' => isset($campaignRolePermissions[$key]),
                ];
            }

            // Attributes
            foreach ($actions as $action) {
                $key = "{$entity}_attributes_{$action}";
                $table = "{$entity}_attributes";
                $permissions[] = [
                    'entity' => $entity . ' attributes',
                    'action' => $action,
                    'table' => $table,
                    'key' => $key,
                    'enabled' => isset($campaignRolePermissions[$key]),
                ];
            }

            // Relations
            foreach ($actions as $action) {
                $key = "{$entity}_relations_{$action}";
                $table = "{$entity}_relations";
                $permissions[] = [
                    'entity' => $entity . ' relations',
                    'action' => $action,
                    'table' => $table,
                    'key' => $key,
                    'enabled' => isset($campaignRolePermissions[$key]),
                ];
            }

            // Members or org?
            if ($entity == 'organisations') {
                foreach ($actions as $action) {
                    $key = "{$entity}_members_{$action}";
                    $table = "{$entity}_members";
                    $permissions[] = [
                        'entity' => $entity . ' members',
                        'action' => $action,
                        'table' => $table,
                        'key' => $key,
                        'enabled' => isset($campaignRolePermissions[$key]),
                    ];
                }
            }
        }

        return $permissions;
    }
}
