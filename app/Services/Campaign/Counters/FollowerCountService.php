<?php

namespace App\Services\Campaign\Counters;

use App\Traits\CampaignAware;

class FollowerCountService
{
    use CampaignAware;

    protected int $count;

    public function process()
    {
        $this->count()
            ->save()
            ->cleanup();
    }

    protected function count(): self
    {
        $this->count = $this->campaign->followers_count;

        return $this;
    }

    protected function save(): self
    {
        $this->campaign->follower = $this->count;
        $this->campaign->updateQuietly(['follower']);

        return $this;
    }

    protected function cleanup(): void
    {
        unset($this->campaign);
        unset($this->count);
    }
}
