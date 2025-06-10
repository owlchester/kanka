<?php

namespace App\Services\Caches\Traits\Campaign;

trait ApplicationCache
{
    public function applicationsCount(): int
    {
        return $this->primary($this->campaign->id)->get('applications');
    }

    protected function formatApplications(): int
    {
        return $this->campaign->applications->count();
    }
}
