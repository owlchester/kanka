<?php

namespace App\Traits;

use App\Models\CampaignRole;

trait RoleAware
{
    private CampaignRole $role;

    public function role(CampaignRole $role): self
    {
        $this->role = $role;

        return $this;
    }
}
