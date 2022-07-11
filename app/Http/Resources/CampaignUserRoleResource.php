<?php

namespace App\Http\Resources;

use App\Models\CampaignRole;

class CampaignUserRoleResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var CampaignRole $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'is_admin' => $model->isAdmin(),
        ];
    }
}
