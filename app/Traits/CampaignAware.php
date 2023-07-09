<?php

namespace App\Traits;

use App\Models\Campaign;

/**
 * Trait for campaign aware services
 */
trait CampaignAware
{
    /** @var Campaign|null campaign model */
    public $campaign;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }
}
