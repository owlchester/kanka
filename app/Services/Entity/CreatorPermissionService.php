<?php

namespace App\Services\Entity;

use App\Enums\Permission;
use App\Facades\Permissions;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\User;

class CreatorPermissionService
{
    protected Entity $entity;

    protected ?User $user = null;

    public function entity(Entity $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function user(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * If the creator doesn't already have permission to view or update their newly created entity,
     * automatically grant them those permissions.
     */
    public function grant(): void
    {
        if (! $this->user instanceof User) {
            return;
        }

        if (! $this->user->can('view', $this->entity)) {
            $this->createPermission(Permission::View->value);
        }

        if (! $this->user->can('update', $this->entity)) {
            $this->createPermission(Permission::Update->value);
        }
    }

    protected function createPermission(int $action): CampaignPermission
    {
        $permission = new CampaignPermission;
        $permission->entity_id = $this->entity->id;
        $permission->entity_type_id = $this->entity->type_id;
        $permission->campaign_id = $this->entity->campaign_id;
        $permission->user_id = $this->user->id;
        $permission->action = $action;
        $permission->access = true;
        $permission->save();
        Permissions::grant($this->entity);

        return $permission;
    }
}
