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
    protected function authorizeForGuest($action, $model, string $modelType = null)
    {
        $campaign = CampaignLocalization::getCampaign();
        if (empty($modelType)) {
            $mainModel = new $this->model;
            $modelType = $mainModel->getEntityType();
        }
        $permission = EntityPermission::hasPermission($modelType, $action, null, $model, $campaign);

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
        $permission = EntityPermission::hasPermission($model->getEntityType(), $action, null, $model, $campaign);

        if ($campaign->id != $model->campaign_id || !$permission) {
            // Raise an error
            abort('403');
        }
    }
}
