<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Models\MiscModel;

class MenuLinkObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        $model->campaign_id = CampaignLocalization::getCampaign()->id;
        $model->icon = '';
        $model->tab = strtolower($model->target);

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }
}
