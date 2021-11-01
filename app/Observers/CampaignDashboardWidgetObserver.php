<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Models\CampaignDashboardWidget;
use App\Models\Tag;

class CampaignDashboardWidgetObserver
{
    /**
     * @param CampaignDashboardWidget $model
     */
    public function saving(CampaignDashboardWidget $model)
    {
        $model->campaign_id = CampaignLocalization::getCampaign()->id;
    }

    /**
     * @param CampaignDashboardWidget $model
     */
    public function creating(CampaignDashboardWidget $model)
    {
        // Get position
        $model->position = 0;
        $last = CampaignDashboardWidget::onDashboard($model->dashboard)
            ->with('entity')
            ->orderBy('position', 'desc')
            ->first();
        if (!empty($last)) {
            $model->position = $last->position + 1;
        }
    }
}
