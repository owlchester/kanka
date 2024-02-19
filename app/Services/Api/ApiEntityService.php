<?php

namespace App\Services\Api;

use App\Models\MiscModel;
use App\Models\Campaign;

class ApiEntityService
{
    /**
     */
    public function saveEntity(array $entity, MiscModel $class, Campaign $campaign)
    {
        $tags = [];

        // Prepare the data
        unset($entity['module']);
        if (!empty($entity['entry'])) {
            $entity['entry'] = nl2br($entity['entry']);
        }
        if (isset($entity['tags'])) {
            $tags = $entity['tags'];
        }
        request()->merge(['tags' => $tags]);

        /** @var MiscModel $new */
        $new = new $class($entity);
        $new->campaign_id = $campaign->id;
        $new->save();
        $new->crudSaved();
        $new->entity->crudSaved();

        return $new;
    }
}
