<?php

namespace App\Services\Campaign;

use App\Enums\CampaignVisibility;
use App\Traits\CampaignAware;

class ShareService
{
    use CampaignAware;

    /**
     * Make the campaign publicly visible.
     */
    public function makePublic(): self
    {
        $this->campaign->update(['visibility_id' => CampaignVisibility::public->value]);

        return $this;
    }
}
