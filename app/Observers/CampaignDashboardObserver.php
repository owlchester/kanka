<?php

namespace App\Observers;

use App\Models\CampaignDashboard;

class CampaignDashboardObserver
{
    /**
     */
    public function saved(CampaignDashboard $model)
    {
        $sourceId = request()->post('source');
        if (request()->has('copy_widgets') && request()->filled('copy_widgets')) {
            /** @var CampaignDashboard|null $source */
            $source = CampaignDashboard::find($sourceId);
            if (empty($source)) {
                return;
            }
            foreach ($source->widgets()->with('dashboardWidgetTags')->get() as $widget) {
                $widget->copyTo($model);
            }
        }
    }
}
