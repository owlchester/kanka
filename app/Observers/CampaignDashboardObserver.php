<?php

namespace App\Observers;

use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;

class CampaignDashboardObserver
{
    /**
     */
    public function saved(CampaignDashboard $model)
    {
        $sourceId = request()->post('source');
        if (request()->has('copy_widgets') && request()->filled('copy_widgets')) {
            /** @var ?CampaignDashboard $source */
            $source = CampaignDashboard::find($sourceId);
            if (empty($source)) {
                return;
            }
            /** @var CampaignDashboardWidget $widget */
            foreach ($source->widgets()->with('dashboardWidgetTags')->get() as $widget) {
                $widget->copyTo($model);
            }
        }
    }
}
