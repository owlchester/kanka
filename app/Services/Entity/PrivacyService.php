<?php

namespace App\Services\Entity;

use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Models\User;

class PrivacyService
{
    protected array $data;

    protected Entity $entity;

    /**
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    public function visibilities(): array
    {
        $this->data = ['roles' => [], 'users' => []];

        /** @var CampaignRole[] $roles */
        $roles = $this->entity->campaign->roles()->with('permissions')->get();
        foreach ($roles as $role) {
            if ($role->isAdmin()) {
                continue;
            }
            // General role permission
            $perm = $role->permissions
                ->where('action', CampaignPermission::ACTION_READ)
                ->whereNull('entity_id')
                ->where('entity_type_id', $this->entity->type_id);
            if ($perm->count() > 0) {
                // Add unless it's on the entity denied
                $subPerm = $role->permissions
                    ->where('action', CampaignPermission::ACTION_READ)
                    ->where('entity_id', $this->entity->id)
                    ->where('access', 0);
                if ($subPerm->count() === 0) {
                    $this->data['roles'][] = $role;
                    continue;
                }
            }
            // Specific entity
            $perm = $role->permissions
                ->where('action', CampaignPermission::ACTION_READ)
                ->where('entity_id', $this->entity->id)
                ->where('access', 1);
            if ($perm->count() > 0) {
                $this->data['roles'][] = $role;
            }
        }

        $this->members();


        return $this->data;
    }

    public function toggle(): self
    {
        return $this;
    }

    protected function members(): self
    {
        /** @var User[] $users[] */
        $users = $this->entity->campaign->users()->with('permissions')->get();
        foreach ($users as $user) {
            // Specific entity
            $perm = $user->permissions
                ->where('campaign_id', $this->entity->campaign_id)
                ->where('action', CampaignPermission::ACTION_READ)
                ->where('entity_id', $this->entity->id)
                ->where('access', 1);
            if ($perm->count() > 0) {
                $this->data['users'][] = $user;
            }
        }
        return $this;
    }
}
