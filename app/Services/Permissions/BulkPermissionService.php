<?php

namespace App\Services\Permissions;

use App\Models\CampaignPermission;
use App\Traits\EntityAware;

class BulkPermissionService
{
    use EntityAware;

    protected \App\Services\PermissionService $service;

    protected array $permissions;

    protected bool $override;

    public function __construct(\App\Services\PermissionService $permissionService)
    {
        $this->service = $permissionService;
    }

    public function override(bool $override): self
    {
        $this->override = $override;

        return $this;
    }

    public function change(array $request): void
    {
        // First, let's get all the stuff for this entity
        $this->permissions = $this->service
            ->clearEntityPermissions()
            ->entityPermissions($this->entity);

        $this
            ->roles($request)
            ->users($request)
            ->cleanup();
    }

    protected function roles(array $request): self
    {
        if (empty($request['role'])) {
            return $this;
        }
        foreach ($request['role'] as $roleId => $data) {
            foreach ($data as $perm => $action) {
                if ($action == 'allow') {
                    if (empty($this->permissions['role'][$roleId][$perm])) {
                        CampaignPermission::create([
                            'campaign_role_id' => $roleId,
                            'campaign_id' => $this->entity->campaign_id,
                            'entity_id' => $this->entity->id,
                            'action' => $perm,
                            'access' => true,
                        ]);
                    } else {
                        $this->permissions['role'][$roleId][$perm]->update(['access' => true]);
                        unset($this->permissions['role'][$roleId][$perm]);
                    }
                } elseif ($action == 'remove') {
                    if (! empty($this->permissions['role'][$roleId][$perm])) {
                        $this->permissions['role'][$roleId][$perm]->delete();
                        unset($this->permissions['role'][$roleId][$perm]);
                    }
                } elseif ($action === 'deny') {
                    if (empty($this->permissions['role'][$roleId][$perm])) {
                        CampaignPermission::create([
                            'campaign_role_id' => $roleId,
                            'campaign_id' => $this->entity->campaign_id,
                            'entity_id' => $this->entity->id,
                            'action' => $perm,
                            'access' => false,
                        ]);
                    } else {
                        $this->permissions['role'][$roleId][$perm]->update(['access' => false]);
                        unset($this->permissions['role'][$roleId][$perm]);
                    }
                } elseif ($action == 'inherit') {
                    // Inherit? Remove it if it exists
                    if (! empty($this->permissions['role'][$roleId][$perm])) {
                        $this->permissions['role'][$roleId][$perm]->delete();
                    }
                }
            }
        }

        return $this;
    }

    protected function users(array $request): self
    {
        if (empty($request['user'])) {
            return $this;
        }
        foreach ($request['user'] as $userId => $data) {
            foreach ($data as $perm => $action) {
                if ($action == 'allow') {
                    if (empty($this->permissions['user'][$userId][$perm])) {
                        CampaignPermission::create([
                            // 'key' => $this->entity->entityType->code . '_' . $perm . '_' . $this->entity->child->id,
                            'user_id' => $userId,
                            'campaign_id' => $this->entity->campaign_id,
                            'entity_id' => $this->entity->id,
                            // 'entity_type_id' => $this->entity->type_id,
                            'action' => $perm,
                            'access' => true,
                        ]);
                    } else {
                        $this->permissions['user'][$userId][$perm]->update(['access' => true]);
                        unset($this->permissions['user'][$userId][$perm]);
                    }
                } elseif ($action == 'remove') {
                    if (! empty($this->permissions['user'][$userId][$perm])) {
                        $this->permissions['user'][$userId][$perm]->delete();
                        unset($this->permissions['user'][$userId][$perm]);
                    }
                } elseif ($action === 'deny') {
                    if (empty($this->permissions['user'][$userId][$perm])) {
                        CampaignPermission::create([
                            // 'key' => $this->entity->entityType->code . '_' . $perm . '_' . $this->entity->child->id,
                            'user_id' => $userId,
                            'campaign_id' => $this->entity->campaign_id,
                            'entity_id' => $this->entity->id,
                            'action' => $perm,
                            'access' => false,
                        ]);
                    } else {
                        $this->permissions['user'][$userId][$perm]->update(['access' => false]);
                    }
                } elseif ($action == 'inherit') {
                    // Inherit? Remove it if it exists
                    if (! empty($this->permissions['user'][$userId][$perm])) {
                        $this->permissions['user'][$userId][$perm]->delete();
                    }
                }
            }
        }

        return $this;
    }

    protected function cleanup(): void
    {
        // If the user requested an override, any permissions that was not specifically set will be deleted.
        if (! $this->override) {
            return;
        }
        foreach ($this->permissions as $type => $data) {
            foreach ($data as $user => $actions) {
                foreach ($actions as $action => $perm) {
                    $perm->delete();
                }
            }
        }
    }
}
