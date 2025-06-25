<?php

namespace App\Observers;

use App\Events\Campaigns\Dashboards\DashboardCreated;
use App\Events\Campaigns\Dashboards\DashboardDeleted;
use App\Events\Campaigns\Dashboards\DashboardUpdated;
use App\Models\CampaignDashboard;

class CampaignDashboardObserver
{
    public function created(CampaignDashboard $campaignDashboard)
    {
        DashboardCreated::dispatch($campaignDashboard, auth()->user());
    }

    public function updated(CampaignDashboard $campaignDashboard)
    {
        DashboardUpdated::dispatch($campaignDashboard, auth()->user());
    }

    public function deleted(CampaignDashboard $campaignDashboard)
    {
        DashboardDeleted::dispatch($campaignDashboard, auth()->user());
    }
}
