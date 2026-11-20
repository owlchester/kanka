<?php

namespace App\Services\Caches\Traits\Campaign;

trait ApplicationCache
{
    public function applicationsCount(): int
    {
        return $this->primary($this->activeCampaign()->id)->get('applications');
    }

    protected function formatApplications(): int
    {
        return $this->activeCampaign()->applications->count();
    }
}
