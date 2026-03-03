<?php

namespace App\Services\Entity;

use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;

class ShareService
{
    use CampaignAware;
    use EntityAware;

    /**
     * Share the entity with the public role using entity-level permissions.
     */
    public function shareEntity(): self
    {
        $publicRole = $this->campaign->roles()->public()->first();

        if ($this->entity->is_private) {
            $this->entity->update(['is_private' => false]);
        }

        CampaignPermission::updateOrCreate(
            [
                'campaign_id' => $this->campaign->id,
                'campaign_role_id' => $publicRole->id,
                'entity_id' => $this->entity->id,
                'action' => CampaignPermission::ACTION_READ,
            ],
            [
                'access' => true,
            ]
        );

        $this->entity->refresh();

        return $this;
    }

    /**
     * Share all entities of the same type with the public role using global permissions.
     */
    public function shareGlobal(): self
    {
        $publicRole = $this->campaign->roles()->public()->first();

        CampaignPermission::updateOrCreate(
            [
                'campaign_id' => $this->campaign->id,
                'campaign_role_id' => $publicRole->id,
                'entity_type_id' => $this->entity->type_id,
                'entity_id' => null,
                'action' => CampaignPermission::ACTION_READ,
            ],
            [
                'access' => true,
            ]
        );

        $this->entity->refresh();

        return $this;
    }
}
