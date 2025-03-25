<?php

namespace App\Http\Resources;

use App\Models\CampaignPermission;

class EntityPermissionResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var CampaignPermission $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'campaign_role_id' => $model->campaign_role_id,
            'user_id' => $model->user_id,
            'action' => $model->action,
            'access' => (bool) $model->access,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
