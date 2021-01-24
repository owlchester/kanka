<?php

namespace App\Observers;

use App\Models\Ability;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Models\MiscModel;

class CampaignDashboardObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param CampaignDashboard $model
     */
    public function saving(CampaignDashboard $model)
    {
        $model->name = $this->purify($model->name);
    }

    /**
     * @param CampaignDashboard $model
     */
    public function saved(CampaignDashboard $model)
    {
        $sourceId = request()->post('source');
        if (request()->has('copy_widgets') && request()->filled('copy_widgets')) {
            /** @var CampaignDashboard $source */
            $source = CampaignDashboard::find($sourceId);
            if (empty($source)) {
                return;
            }
            foreach ($source->widgets as $widget) {
                $widget->copyTo($model);
            }
        }
    }
}
