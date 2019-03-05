<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Facades\EntityPermission;
use App\Models\Entity;
use App\Models\MiscModel;

trait GuestAuthTrait
{
    /**
     * Secondary Authentication for Guest users
     * @param $action
     * @param $model
     */
    protected function authorizeForGuest($action, $model)
    {
        $campaign = CampaignLocalization::getCampaign();
        $mainModel = new $this->model;
        $permission = EntityPermission::hasPermission($mainModel->getEntityType(), $action, null, $model, $campaign);

        if ($campaign->id != $model->campaign_id || !$permission) {
            // Raise an error
            abort('403');
        }
    }

    /**
     * Secondary Authentication for Guest users
     * @param $action
     * @param $model
     */
    protected function authorizeEntityForGuest($action, MiscModel $model)
    {
        $campaign = CampaignLocalization::getCampaign();
        $permission = EntityPermission::hasPermission($model->getEntityType(), $action, null, $model->child, $campaign);

        if ($campaign->id != $model->campaign_id || !$permission) {
            // Raise an error
            abort('403');
        }
    }
}
