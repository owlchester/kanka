<?php

namespace App\Http\Resources;

use App\Models\CampaignDashboardWidget;

class CampaignDashboardWidgetResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var CampaignDashboardWidget $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'campaign_id' => $model->campaign_id,
            'entity_id' => $model->entity_id,
            'widget' => $model->widget,
            'config' => $model->config,
            'width' => (int) $model->width,
            'position' => (int) $model->position,
            'tags' => $model->tags()->pluck('id')->toArray(),

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
            'created_by' => $model->created_by,
            'updated_by' => $model->updated_by,
        ];
    }
}
