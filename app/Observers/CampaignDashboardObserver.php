<?php

namespace App\Observers;

use App\Models\Ability;
use App\Models\CampaignDashboard;
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
}
