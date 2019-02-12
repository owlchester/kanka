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
        $model->tab = strtolower(trim($model->tab, '#'));

        if (!empty($model->type)) {
            $model->entity_id = null;
            $model->tab = null;
            $model->menu = '';
        } else {
            $model->type = null;
            $model->filters = null;
        }

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }
}
