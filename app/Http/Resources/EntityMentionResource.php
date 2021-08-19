<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EntityMentionResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'entity_id' => $this->entity_id,
            'entity_note_id' => $this->entity_note_id,
            'campaign_id' => $this->campaign_id,
            'target_id' => $this->target_id,
        ];
    }
}
