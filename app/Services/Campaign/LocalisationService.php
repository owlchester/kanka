<?php

namespace App\Services\Campaign;

use App\Models\Campaign;

/**
 * Use this facade to get the current campaign ID when needed.
 * To keep the code clean, avoid this, as it's available in every controller and on every model as a
 * campaign_id property.
 */
class LocalisationService
{
    /** @var Campaign|null The current campaign context */
    protected ?Campaign $campaign = null;

    /** @var int console campaign id */
    protected int $consoleCampaignId = 0;

    public function hasCampaign(): bool
    {
        return $this->getCampaign() instanceof Campaign;
    }

    /**
     * Get the campaign
     */
    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    /**
     * Force the campaign. This is use for moving entities between campaigns.
     */
    public function forceCampaign(Campaign $campaign): void
    {
        $this->campaign = $campaign;
    }

    public function clear(): self
    {
        $this->campaign = null;
        $this->consoleCampaignId = 0;

        return $this;
    }

    public function getConsoleCampaign(): int
    {
        return $this->consoleCampaignId;
    }

    public function setConsoleCampaign(int $campaignId): self
    {
        $this->consoleCampaignId = $campaignId;

        return $this;
    }
}
