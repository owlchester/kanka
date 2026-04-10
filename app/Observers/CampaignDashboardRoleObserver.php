<?php

namespace App\Observers;

use App\Events\Campaigns\Dashboards\DashboardUpdated;
use App\Models\CampaignDashboardRole;

class CampaignDashboardRoleObserver
{
    public function created(CampaignDashboardRole $campaignDashboardRole): void
    {
        DashboardUpdated::dispatch($campaignDashboardRole->dashboard, auth()->user());
    }

    public function updated(CampaignDashboardRole $campaignDashboardRole): void
    {
        DashboardUpdated::dispatch($campaignDashboardRole->dashboard, auth()->user());
    }

    public function deleted(CampaignDashboardRole $campaignDashboardRole): void
    {
        DashboardUpdated::dispatch($campaignDashboardRole->dashboard, auth()->user());
    }
}
