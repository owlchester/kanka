<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Models\CampaignDashboardWidget;

class CampaignDashboardWidgetObserver
{
    public function saving(CampaignDashboardWidget $model)
    {
        $model->campaign_id = CampaignLocalization::getCampaign()->id;

        $model->config = json_encode(empty($model->config) ? [] : $model->config, JSON_UNESCAPED_SLASHES);

        if ($model->widget == CampaignDashboardWidget::WIDGET_RECENT) {

        }
    }

    public function creating(CampaignDashboardWidget $model)
    {
        // Get position
        $model->position = 0;
        $last = CampaignDashboardWidget::with('entity')->orderBy('position', 'desc')->first();
        if (!empty($last)) {
            $model->position = $last->position + 1;
        }
    }
}
