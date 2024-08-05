<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Facades\EntityPermission;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\MiscModel;

trait GuestAuthTrait
{
    public function authView(MiscModel $model): void
    {
        if (auth()->check()) {
            $this->authorize('view', $model);
        } else {
            $this->authorizeForGuest(CampaignPermission::ACTION_READ, $model);
        }
    }

    public function authEntityView(?Entity $entity = null): void
    {
        if (empty($entity)) {
            abort(403);
        }
        if (!$entity->child) {
            abort(404);
        }
        if (auth()->check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(CampaignPermission::ACTION_READ, $entity->child);
        }
    }

    /**
     * Secondary Authentication for Guest users
     * @return void
     */
    protected function authorizeForGuest(int $action, ?MiscModel $model = null, ?int $modelType = null)
    {
        $campaign = CampaignLocalization::getCampaign();
        if (empty($modelType)) {
            if (!property_exists($this, 'model')) {
                abort(403);
            }
            $mainModel = new $this->model();
            $modelType = $mainModel->entityTypeId();
        }
        //        dump($modelType);
        //        dump($action);
        //        dump($model);
        //        dump($campaign);
        $permission = EntityPermission::hasPermission($modelType, $action, null, $model, $campaign);
        //        dd($permission);

        // @phpstan-ignore-next-line
        if ($campaign->id != $model->campaign_id || !$permission) {
            // Raise an error
            abort(403);
        }
    }

    /**
     * Secondary Authentication for Guest users
     * @return void
     */
    protected function authorizeEntityForGuest(int $action, ?MiscModel $model = null)
    {
        // If the misc model is null ($entity->child), the user has no valid access
        if ($model === null) {
            abort(403);
        }

        $campaign = CampaignLocalization::getCampaign();
        $permission = EntityPermission::hasPermission($model->entityTypeId(), $action, null, $model, $campaign);

        // @phpstan-ignore-next-line
        if ($campaign->id != $model->campaign_id || !$permission) {
            // Raise an error
            abort(403);
        }
    }
}
