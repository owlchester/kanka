<?php

namespace App\Services\Api;

use App\Facades\EntityPermission;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\User;
use Illuminate\Http\Request;

class ApiPermissionService
{
    protected $cachedPermissions;

    /**
     * Get the permissions of an entity
     */
    protected function entityPermissions(Entity $entity): array
    {
        if (! empty($this->cachedPermissions)) {
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

    /**
     * @param  Request  $request
     */
    public function saveEntity($request, Entity $entity)
    {
        // First, let's get all the stuff for this entity
        $permissions = $this->entityPermissions($entity);
        $model = [];
        // Next, start looping the data
        foreach ($request->all() as $permission) {
            if (! empty($permission['campaign_role_id'])) {
                $key = 'role';
                $key2 = 'campaign_role_id';
            } else {
                $key = 'user';
                $key2 = 'user_id';
            }
            if (empty($permissions[$key][$permission[$key2]][$permission['action']])) {
                $permission['campaign_id'] = $entity->campaign_id;
                $permission['entity_type_id'] = $entity->type_id;
                $permission['entity_id'] = $entity->id;
                $permission['misc_id'] = $entity->child->id;
                array_push($model, CampaignPermission::create($permission));
            }
        }

        return $model;
    }

    /**
     * @param  Request  $request
     */
    public function entityPermissionTest($request, Campaign $campaign): array
    {
        $previousUser = 0;
        $permissionTest = [];
        foreach ($request->all() as $test) {
            $entityTypeId = null;
            /** @var Entity|MiscModel|null $entity */
            $entity = null;
            $entityId = null;
            if (! isset($user) || $user != $previousUser) {
                $user = User::find($test['user_id']);
                EntityPermission::resetPermissions();
            }

            if (isset($test['entity_type_id'])) {
                $entityTypeId = $test['entity_type_id'];
            } else {
                $entity = Entity::find($test['entity_id']);
                $entityTypeId = $entity->type_id;
                $entityId = $entity->id;
            }

            $permission = EntityPermission::campaign($campaign)->user($user)->hasPermission($entityTypeId, $test['action'], $entity);

            $permissionTest[] = ([
                'entity_type_id' => $entityTypeId,
                'entity_id' => $entityId,
                'user_id' => $test['user_id'],
                'action' => $test['action'],
                'can' => $permission,
            ]);
            $previousUser = $user;
        }

        return $permissionTest;
    }
}
