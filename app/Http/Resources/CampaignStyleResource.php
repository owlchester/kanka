<?php

namespace App\Http\Resources;

use App\Models\CampaignStyle;

class CampaignStyleResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var CampaignStyle $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'campaign_id' => $model->campaign_id,
            'name' => $model->name,
            'content' => $model->content,
            'is_enabled' => $model->is_enabled,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
            'created_by' => $model->created_by,
        ];
    }
}
