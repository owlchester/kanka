<?php

namespace App\Http\Resources;

use App\Models\CampaignRole;
use Illuminate\Http\Request;

class CampaignUserRoleResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
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
