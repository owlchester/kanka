<?php

namespace App\Observers;

use App\Events\DashboardWidgetChanged;
use App\Models\CampaignDashboardWidget;

class CampaignDashboardWidgetObserver
{
    public function creating(CampaignDashboardWidget $model)
    {
        // Get position
        $model->position = 0;
        $last = CampaignDashboardWidget::onDashboard($model->dashboard)
            ->with('entity')
            ->orderBy('position', 'desc')
            ->first();
        if (! empty($last)) {
            $model->position = $last->position + 1;
        }
    }
}
