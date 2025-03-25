<?php

namespace App\Traits;

use App\Models\Campaign;

/**
 * Trait for campaign aware services
 */
trait CampaignAware
{
    public Campaign $campaign;

    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }
}
