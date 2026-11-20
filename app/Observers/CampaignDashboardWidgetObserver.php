<?php

namespace App\Observers;

use App\Models\CampaignDashboardWidget;

class CampaignDashboardWidgetObserver
{
    public function creating(CampaignDashboardWidget $model)
    {
        if ($model->position !== null) {
            return;
        }

        // Get position
        $model->position = 0;
        $last = CampaignDashboardWidget::onDashboard($model->dashboard)
            ->where('campaign_id', $model->campaign_id)
            ->orderBy('position', 'desc')
            ->first();
        if (! empty($last)) {
            $model->position = $last->position + 1;
        }
    }
}
