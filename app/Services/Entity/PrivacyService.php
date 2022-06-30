<?php

namespace App\Services\Entity;

use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignUser;
use App\Models\Entity;
use App\User;

class PrivacyService
{
    /** @var Entity */
    protected Entity $entity;

    /**
     * @param Entity $entity
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    public function visibilities(): array
    {
        $data = ['roles' => [], 'users' => []];

        /** @var CampaignRole $role */
        $roles = $this->entity->campaign->roles()->with('permissions')->get();
        foreach ($roles as $role) {
            if ($role->isAdmin()) {
                continue;
            }
            // General role permission
            $perm = $role->permissions
                ->where('action', CampaignPermission::ACTION_READ)
                ->where('entity_type_id', $this->entity->type_id);
            if ($perm->count() > 0) {
                $data['roles'][] = $role->name;
                continue;
            }
            // Specific entity
            $perm = $role->permissions
                ->where('action', CampaignPermission::ACTION_READ)
                ->where('entity_id', $this->entity->id)
                ->where('access', 1);
            if ($perm->count() > 0) {
                $data['roles'][] = $role->name;
            }
        }

        /** @var User $user */
        $users = $this->entity->campaign->users()->with('permissions')->get();
        foreach ($users as $user) {
            // Specific entity
            $perm = $user->permissions
                ->where('campaign_id', $this->entity->campaign_id)
                ->where('action', CampaignPermission::ACTION_READ)
                ->where('entity_id', $this->entity->id)
                ->where('access', 1);
            if ($perm->count() > 0) {
                $data['users'][] = $user->name;
            }
        }
        return $data;
    }

    public function toggle(): self
    {
        return $this;
    }
}
