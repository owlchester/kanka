<?php

namespace App\Http\Resources;

use App\Models\EntityMention;
use Illuminate\Http\Request;

class EntityMentionResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityMention $model */
        $model = $this->resource;

        return [
            'entity_id' => $model->entity_id,
            'post_id' => $model->post_id,
            'campaign_id' => $model->campaign_id,
            'target_id' => $model->target_id,
        ];
    }
}
